<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\InOut;
use App\Models\Izin;
use App\Models\JenisIzin;
use App\Models\Shift;
use App\Models\SiteSetting;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class IzinController extends Controller
{

    private $hour;
    
    public function __construct()
    {
        if (!Auth::check()) {
            // rest of the constructor code
            return redirect('/login');
        }
        
        $cek_shift = General::cekShift(auth()->user()->shift);
        $time = Carbon::createFromFormat('H:i', $cek_shift['jam_masuk']);
        $hour = intval($time->format('H'));
        
        $this->hour = $hour;
    }

    public function index()
    {

        if(auth()->user()->is_web == 0) {
            return redirect()->back()->with('error', 'anda tidak punya akses kesini. Silakan hubungi admin untuk dapat melakukan permohonan izin via web app.');
        }

        $waktu = gmdate("H:i", time() + 7 * 3600);
        $t = explode(":", $waktu);
        $jam = $t[0];
        $menit = $t[1];

        $ucapan = "";
        if ($jam >= 00 and $jam < 10) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Pagi";
            }
        } else if ($jam >= 10 and $jam < 15) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Siang";
            }
        } else if ($jam >= 15 and $jam < 18) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Sore";
            }
        } else if ($jam >= 18 and $jam <= 24) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Malam";
            }
        } else {
            $ucapan = "Error";
        }

        $head = [
            'title' => 'Permohonan Izin',
            'head_title_per_page' => "Permohonan Izin",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Permohonan Izin',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];


        $data = Izin::where([
            'created_by' => auth()->user()->id,
            'is_active' => 1
        ])->orderBy('created_at', 'DESC')->get();

        $jenis_izin = JenisIzin::where('is_active', 1)->orderBy('id', 'ASC')->get();

        $check_shift = General::cekShift(auth()->user()->shift);
        $jam_pulang = date( 'H:i:s', strtotime($check_shift['jam_pulang']));

        return view('pages.employee.izin', compact('head', 'ucapan', 'data', 'jam_pulang', 'jenis_izin'));
    }

    public function send(Request $request)
    {
        // return $request->all();
        $jenis = JenisIzin::where([
            'id' => $request->type,
            'is_active' => 1
        ])->first();

        // dd($jenis);
        if($jenis->slug == 'sakit') {
            $validator =  Validator::make($request->all(), [
                'type' => 'required',
                'alasan' => 'required|min:5|max:100',
                'latlong' => 'required',
                'dokumen' => 'required|max:6000|mimes:pdf,jpg,jpeg,png,gif',
            ]);
        } else {
            $validator =  Validator::make($request->all(), [
                'type' => 'required',
                'alasan' => 'required|min:5|max:100',
                'latlong' => 'required',
                'dokumen' => 'max:6000|mimes:pdf,jpg,jpeg,png,gif',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
            
        } else {

            DB::beginTransaction();

            try {

                 // cek user diizinkan login via mobile atau tidak
                 if(auth()->user() == null) {
                    return redirect()->route('logout');
                }
                

                $doc = $request->dokumen;

                // $file_name = null;
                if($doc) {
                    $path = public_path('uploads/izin');
                    if (!File::exists($path)) File::makeDirectory($path, 0775,true,true,true);
                    $file = $doc;
                    $ext = $file->getClientOriginalExtension();

                    $file_name =  'izin-' . time() . '-' . Str::slug(auth()->user()->full_name) . '-' .date('YmdHis'). '.'. $ext;

                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') { //image
                        $file = Image::make($file->getRealPath());
                        $file->resize(800, 800, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.'/'.$file_name);
                    } else { // document
                        $file->move($path, $file_name);    
                    }
                } 
    
    
                $izin = Izin::create([
                    'jenis_izin_id' => $request->type,
                    'alasan' => $request->alasan,
                    'latlong' => $request->latlong,
                    'dokumen' => $file_name ?? null,
                    'is_approve' => 1, // 1:waiting, 2:acc, 3:ditolak
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                    'created_at' => now()
                ]);
                
                
                // dd($izin);
                InOut::create([
                    'shift_id' => auth()->user()->shift,
                    'device' =>  'web',
                    'note_in' => $request->alasan,
                    'latlong_in' => $request->latlong,
                    'type' =>  'absen_izin',
                    'employee_id' =>  auth()->user()->id,
                    'date' => Carbon::now()->toDateString(),
                    'id_izin' => $izin->id,
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                ]);
             

                DB::commit();
                if ($izin) {
                    return redirect()->back()->with('success', 'Izin berhasil dikirim, tunggu validasi dari admin.');  
                } else {
                    return redirect()->back()->with('error', 'Izin gagal dikirim.');  
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Izin gagal.'. $e);  
            }
        }
    }

    public function detail ($id = null) {
        $head = [
            'title' => 'Detail Izin',
            'head_title_per_page' => 'Detail Izin',
            'sub_title_per_page' => ""
        ];

        $data = Izin::where(['id' => $id, 'is_active' => 1])->first();

        return view('pages.employee.izin_detail', compact('head','data'));
    }
}
