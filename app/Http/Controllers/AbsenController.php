<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\InOut;
use App\Models\JenisLembur;
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

class AbsenController extends Controller
{

    private $hour;
    private $yesterday_date;
    private $today_date;
    private $tomorrow_date;
    
    public function __construct()
    {
        if(auth()->user() == null) {
            return redirect()->route('logout');
        }
        
        $cek_shift = General::cekShift(auth()->user()->shift);
        $time = Carbon::createFromFormat('H:i', $cek_shift['jam_masuk']);
        $hour = intval($time->format('H'));
        $minute = intval($time->format('i'));
        $second = 00;
        
        $this->hour = $hour;

        $kemarin = Carbon::yesterday();
        $kemarin->hour = $hour;
        $kemarin->minute = $minute;
        $kemarin = $kemarin->toDateTimeString();
        // $this->yesterday_date = date('Y-m-d H:i:s',strtotime($kemarin));
        $this->yesterday_date = $kemarin;

        $hari_ini = Carbon::today();
        $hari_ini->hour = $hour;
        $hari_ini->minute = $minute;
        $hari_ini = $hari_ini->toDateTimeString();
        // $this->today_date = date('Y-m-d H:i:s',strtotime($hari_ini));
        $this->today_date = $hari_ini;
        
        $besok = Carbon::tomorrow();
        $besok->hour = $hour;
        $besok->minute = $minute;
        $besok = $besok->toDateTimeString();
        // $this->tomorrow_date = date('Y-m-d H:i:s',strtotime($besok));
        $this->tomorrow_date = $besok;
    }

    public function index()
    {

        $head = [
            'title' => 'Presensi IN/OUT',
            'head_title_per_page' => "Presensi IN/OUT",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Presensi IN/OUT',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];

        if(auth()->user()->is_web == 0) {
            return redirect()->back()->with('error', 'Anda tidak punya akses kesini. Silakan hubungi admin untuk dapat melakukan Presensi via web app.');
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

        $absen = InOut::where([
            'employee_id' => auth()->user()->id,
            'date' => Carbon::now()->toDateString(),
            'is_active' => 1
        ])->orderBy('id', 'DESC')->first();

        $logAbsen = InOut::where([
            'employee_id' => auth()->user()->id,
            'is_active' => 1
        ])
        ->where('type', 'absen_biasa')
        ->orWhere('type', 'absen_lembur')
        ->orderBy('created_at', 'DESC')->get();

        // dd($logAbsen);

        if($absen) {
            $absen = $absen;
        } else {
            $absen = new InOut();
        }
        $users = User::where('is_active', 1)->where('role', 'user')->orderBy('full_name', 'ASC')->get();
        $jenis_lembur = JenisLembur::where('is_active', 1)->orderBy('type', 'ASC')->get();

        $check_shift = General::cekShift(auth()->user()->shift);
        $jam_pulang = date( 'H:i:s', strtotime($check_shift['jam_pulang']));

        // get last attendance yang belum checkout
        $absensi_terakhir = InOut::whereIn('type', ['absen_biasa','absen_lembur'])
        ->where([
            'employee_id' => auth()->user()->id, 
            'date' => Carbon::now()->toDateString()
        ])
        ->whereNotNull('clock_in')
        ->whereNull('clock_out')
        ->latest('id')
        ->first() ?? null;

        // dd($absensi_terakhir);
                        

        return view('pages.employee.absen', compact('head', 'ucapan', 'absen', 'absensi_terakhir', 'logAbsen', 'jam_pulang','jenis_lembur'));
    }

    public function checkInOut(Request $request)
    {

        $type_absen = $request->type;

        // return $request->all();

        if(strtolower($type_absen) == 'absen_lembur_masuk') {
            $validator =  Validator::make($request->all(), [
                'type' => ['required'],
                'note' => ['required'],
                'latlong' => ['required'],
                'jenis_lembur' => ['required'],
                'foto' => ['required']
            ],[
                'type.required' => 'Anda belum memilih jenis presensi. Silakan pilih jenis presensi terlebih dahulu.',
                'note.required' => 'Anda belum memasukan keterangan presensi lembur. Silakan isi dahulu keterangan lembur anda.',
                'latlong.required' => 'GPS anda tidak akti. Silakan nyalakan GPS dan lakukan refresh halaman browser anda.',
                'jenis_lembur.required' => 'Anda belum memilih jenis presensi lembur. Silakan lakukan foto selfie ulang dan pilih presensi yang ingin anda lakukan.',
                'foto.required' => 'Anda belum melakukan foto selfie presensi. Silakan lakukan sesi foto terlebih dahulu.',
            ]);
        } else {
            $validator =  Validator::make($request->all(), [
                'type' => ['required'],
                'latlong' => ['required'],
                'foto' => ['required']
            ],[
                'type.required' => 'Anda belum memilih jenis presensi. Silakan pilih jenis presensi terlebih dahulu.',
                'latlong.required' => 'GPS anda tidak akti. Silakan nyalakan GPS dan lakukan refresh halaman browser anda.',
                'foto.required' => 'Anda belum melakukan foto selfie presensi. Silakan lakukan sesi foto terlebih dahulu.',
            ]);
        }

        // return $type_absen;
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            DB::beginTransaction();

           

            $type_data_record = null;
            if(strtolower($type_absen) == 'absen_biasa_masuk' || strtolower($type_absen) == 'absen_biasa_pulang') {
                $type_data_record = 'absen_biasa';
            } elseif(strtolower($type_absen) == 'absen_lembur_masuk' || strtolower($type_absen) == 'absen_lembur_pulang') {
                $type_data_record = 'absen_lembur';
            } else {
                return redirect()->back()->with('error', 'Absen tidak dikenal.');
            }

            try {
                
                $msg = '';
                
                // cek user harus terdaftar di shift yang sudah dibuat
                if(auth()->user()->shift != null) {
                    if (strtolower($type_absen) == 'absen_biasa_masuk' || strtolower($type_absen) == 'absen_lembur_masuk') {


                        
                        
                        $total_terlambat = null;
                        if($type_absen == 'absen_biasa_masuk') {

                            // cek jika hari ada lembur dan ini belum checkout presensi lembur dari jam 00.00 sd 17.00 tidak bisa presensi masuk
                            $cek_absen_lembur_hari_ini = InOut::where([
                                'employee_id' => auth()->user()->id,
                                'is_active' => 1,
                                // 'created_at' => Carbon::today()
                            ])->where('type', 'absen_lembur')->orderBy('created_at', 'DESC')->first() ?? null;

                            if($cek_absen_lembur_hari_ini != null) {
                                if($cek_absen_lembur_hari_ini->clock_out == null) {
                                    return redirect()->back()->with('error', 'Anda belum checkout lembur sebelumnya. ssilakan checkout lembur dan lakukan presesnsi harian kembali.');
                                } 
                            }

                            // return 'absen_biasa_masuk';
                            // cek jika pernah presensi sebelumnya maka presensi kedua ditolak
                            // $clock_in = InOut::where(['type' => 'absen_biasa', 'employee_id' => auth()->user()->id, 'date' => Carbon::now()->toDateString()])->first()->clock_in ?? null;
                            $cek_today = InOut::where([
                                'type' => 'absen_biasa',
                                'date' => Carbon::now()->format('Y-m-d'),
                                 'employee_id' => auth()->user()->id
                                 ])
                                //  ->whereBetween('created_at', [$this->yesterday_date, $this->tomorrow_date])
                                 ->orderBy('created_at', 'DESC')
                                 ->first() ?? null;

                            if($cek_today != null) {
                                return redirect()->back()->with('error', 'Anda sudah presensi masuk sebelumnya.');
                            } 

                            // cek keterlambatan berdasrkan shift
                            $cek_shift = Shift::where('id', auth()->user()->shift)->first();
                            $cek_libur = General::tanggalMerah(date('Ymd'));
                            $day_now = date('D');
                            if($cek_shift) {
                                if($cek_libur == false) { // hari kerja senin - sabtu
                                    switch($day_now){
                                        case 'Sun':
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->minggu_in)); //start time
        
                                        break;
                                        case 'Mon':			
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->senin_in)); //start time
                                        break;
                                        case 'Tue':
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->selasa_in)); //start time
                                        break;
                                        case 'Wed':
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->rabu_in)); //start time
                                        break;
                                        case 'Thu':
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->kamis_in)); //start time
                                        break;
                                        case 'Fri':
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->jumat_in)); //start time
                                        break;
                                        case 'Sat':
                                            $hari_ini = date('H:i:s', strtotime($cek_shift->sabtu_in)); //start time
                                        break;
                                        default:
                                            $hari_ini = "Tidak di ketahui";		
                                        break;
                                    }
        
                                    // menetukan total waktu keterlambatan
                                    $jam_tentuan = Carbon::createFromFormat('H:i:s', $hari_ini);
                                    $jam_masuk = Carbon::createFromFormat('H:i:s', date('H:i:s'));
                                    // $jam_masuk = Carbon::createFromFormat('H:i:s', $request->in);

                                    if ($jam_masuk->gt($jam_tentuan)) {
                                        $total_terlambat = $jam_masuk->diffInSeconds($jam_tentuan);
                                    } else {
                                        $total_terlambat = null;
                                    }
        
                                } 
                            }
                            
                        }
                        
                        if($type_absen == 'absen_lembur_masuk') {
                            // return 'absen_lembur_masuk';

                            // cek jika presensi lembur tapi belum presensi harian hari ini
                            $cek_harian = InOut::where(['type' => 'absen_biasa','employee_id' => auth()->user()->id, 'date' => Carbon::now()->toDateString()])->first() ?? null;
                        
                            // absen lembur di hari minggu tetap bisa aktif tanpa absen harian terlebih dahulu
                            if (date("D") != "Sun") {
                                //  return 1;
                                if( $cek_harian != null ) {
                                    if($cek_harian->clock_in != null && $cek_harian->clock_out == null) {
                                        return redirect()->back()->with('error', 'Anda tidak bisa presensi lembur karena anda belum presensi harian pulang hari ini.');
                                    }
                                } 
                            }
                        }
    
                        
                        // upload foto masuk
                        $img = $request->foto;
                        if($img) { 
                            $path = public_path('uploads/images/attendance');
                            if (!File::exists($path)) File::makeDirectory($path, 0775,true,true,true);
                            $image_parts = explode(";base64,", $img);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            
                            $image_base64 = base64_decode($image_parts[1]);
                            $foto_name = 'in-'. $type_absen . '-attendance-' . time() . '-' . Str::slug(auth()->user()->full_name) . '-' .date('YmdHis').'.png';
                            
                            $file = $path .'/'. $foto_name;
                            file_put_contents($file, $image_base64);
                        } 
    
                        // simpan data presensi masuk
                        $user = InOut::create([
                            'device' => 'web',
                            'shift_id' => auth()->user()->shift,
                            'type' =>  $type_data_record,
                            'id_jenis_lembur' => $request->jenis_lembur ?? null,
                            'employee_id' => auth()->user()->id,
                            'date' => Carbon::now()->toDateString(),
                            'clock_in' => date('H:i:s'),
                            'late' => $total_terlambat,
                            'time_tolerance_limit' =>  SiteSetting::first()->is_attendace_daily_tolerance_limit == 1 ? SiteSetting::first()->time_minute_attendance_tolerance_limit_daily : 0,
                            'note_in' => $request->note ?? null,
                            'latlong_in' => $request->latlong,
                            'foto_masuk' => $foto_name ?? null,
                            'is_active' => 1,
                            'created_by' => auth()->user()->id,
                            'created_at' => Carbon::now()->toDateTimeString(),
                        ]);
    
                        User::where('id', auth()->user()->id)->update([
                            'last_location'=> $request->latlong
                        ]);
                        $msg = 'masuk';
                    } elseif (strtolower($type_absen) == 'absen_biasa_pulang' || strtolower($type_absen) == 'absen_lembur_pulang') {  
                        
                        // cek jika karyawan belum presensi masuk maka tidak bisa presensi pulang
                        $history = null;
                        if($type_absen == 'absen_biasa_pulang') { 
                            // return 'absen_biasa_pulang';
                            // $history = InOut::where(['type' => 'absen_biasa','employee_id' => auth()->user()->id, 'date' => Carbon::now()->toDateString()])->first();
                            $history = InOut::where(['type' => 'absen_biasa',
                                'date' => Carbon::now()->format('Y-m-d'),
                                'employee_id' => auth()->user()->id
                            ])
                            // ->whereBetween('created_at', [$this->yesterday_date, $this->tomorrow_date])
                            ->orderBy('created_at', 'DESC')
                            ->first();

                            // return $history;
                            if($history) {
                                if($history->clock_in == null) {
                                    return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk.');
                                }
                                // cek jika karyawan sudah pernah presensi pulang maka tidak bisa lagi klik tombol presensi pulang
                                if($history->clock_out != null) {
                                    return redirect()->back()->with('error', 'Anda sudah presensi pulang sebelumnya.');
                                }
                            } else {
                                return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk.');
                            }
                        }
                        
                        if($type_absen == 'absen_lembur_pulang') {
                            // return 'absen_lembur_pulang';
                            // $history = InOut::where(['type' => 'absen_lembur', 'employee_id' => auth()->user()->id, 'date' => Carbon::now()->toDateString()])->first();
                            $history = InOut::where([
                                'type' => 'absen_lembur',
                                // 'date' => Carbon::now()->format('Y-m-d'),
                                 'employee_id' => auth()->user()->id
                                 ])
                            // ->whereBetween('created_at', [$this->yesterday_date, $this->tomorrow_date])
                            ->orderBy('created_at', 'DESC')
                            ->first();
                            // return $history;
                            

                            if($history) {
                                if($history->clock_in == null) {
                                    return redirect()->back()->with('error', 'Anda belum presensi lembur masuk sebelumnya.');
                                } 
                                
                                if($history->clock_out != null) {
                                    return redirect()->back()->with('error', 'Anda sudah presensi pulang lembur sebelumnya.');
                                }
                            } else {
                                return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk lembur.');
                            }
                        }

                        // upload foto absen
                        $img = $request->foto;
                        if($img) {
                            $path = public_path('uploads/images/attendance');
                            if (!File::exists($path)) File::makeDirectory($path, 0775,true,true,true);
                            $image_parts = explode(";base64,", $img);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            
                            $image_base64 = base64_decode($image_parts[1]);
                            $foto_name = 'out-'. $type_absen . '-attendance-' . time() . '-' . Str::slug(auth()->user()->full_name) . '-' .date('YmdHis').'.png';
                            
                            $file = $path .'/'. $foto_name;
                            file_put_contents($file, $image_base64);
                        } 
                
                        // hitung total jam kerja
                        $jam_masuk = Carbon::createFromFormat('Y-m-d H:i:s', $history->date . ' ' . $history->clock_in);
                        $jam_pulang = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                        $totalWork = $jam_pulang->diffInSeconds($jam_masuk);
                            
                        $jenis = $type_absen == 'absen_biasa_pulang' ? 'absen_biasa' : 'absen_lembur';
                        
                        // if($type_absen == 'absen_biasa_pulang') {
                        //     $data['note'] = $request->note ?? null;
                        // }

                        // cek pulang cepat harian
                        $pulang_cepat = null;
                        $cek_shift = General::cekShift(auth()->user()->shift);
                        if($type_data_record == 'absen_biasa' &&
                            // $request->pulang_cepat == 'y' &&
                            strtotime($cek_shift['jam_pulang']) > strtotime(date('H:i:s'))) {
                            $pulang_cepat = date('H:i:s');
                        }
                        
                        $data = [
                            'date_out' => date('Y-m-d'),
                            'clock_out' => date('H:i:s'),
                            'note_out' => $request->note ?? null,
                            'latlong_out' => $request->latlong,
                            'foto_keluar' => $foto_name ?? null,
                            'total_work' => $totalWork ?? null,
                            'early_leave' => $pulang_cepat,
                            'overtime' =>  $history->type == 'absen_lembur' ? $totalWork : null,
                            'updated_by' => auth()->user()->id,
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ];
                        // $user = InOut::where(['type' => $type_absen == 'absen_biasa_pulang' ? 'absen_biasa' : 'absen_lembur', 'employee_id' => auth()->user()->id, 'date' => Carbon::now()->toDateString()])->update([

                        $last_IO = InOut::where([
                            // 'type' => $jenis,
                            'type' => $type_data_record,
                            // 'date' => Carbon::now()->format('Y-m-d'),
                             'employee_id' => auth()->user()->id
                             ])
                            //  ->whereBetween('created_at', [$this->yesterday_date, $this->tomorrow_date])
                             ->orderBy('created_at', 'DESC')
                             ->first();

                        $user = InOut::where('id', $last_IO->id)->update($data);
                        
                        User::where('id', auth()->user()->id)->update([
                            'last_location'=> $request->latlong
                        ]);
                        $msg = 'pulang';
                    } else {
                        return redirect()->back()->with('error', 'Jenis presensi tidak terdeteksi.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Anda belum terdaftar di shift manapun');
                }

                DB::commit();
                if ($user) {
                    return redirect()->back()->with('success', 'Presensi ' . $msg . ' Berhasil.');
                } else {
                    return redirect()->back()->with('error', 'Presensi ' . $msg . ' gagal.');
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failure !');
            }
        }
    }

    public function detail(Request $request, $id=null) {
        $head = [
            'title' => 'Detail Presensi',
            'head_title_per_page' => "Detail Presensi",
            'sub_title_per_page' => "",
        ];
        $data = InOut::where('is_active', 1)->where('id', $id)->first();
        $route_back = route('adm.lembur.delete');
        return view('pages.employee.absen_detail', compact('head','data','route_back'));
    }
}
