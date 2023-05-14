<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\General;
use Illuminate\Support\Facades\Storage;
use App\Models\{AttendanceType, InOut, Shift, User};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Image;
use Intervention\Image\ImageManagerStatic as Image;

class AbsensiController extends Controller
{

    // Attendances Admin
    public function indexAttendance (Request $request) {

        // dd($request->all());
        $head = [
            'title' => 'Data Log Presensi',
            'head_title_per_page' => "Data Log Presensi",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Data Log Presensi',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $date = '';
        $employee_name = '';
        $data = InOut::orderBy('id', 'DESC')->where('is_active', 1);
        $data = $data->whereIn('type', ['absen_biasa', 'absen_lembur']);
        if($request->query('keterangan') == 'belum_checkout') {
            $data = $data->whereNull('clock_out');
            if(!empty($request->date)) {
                $data = $data->where('date', $request->date);
                $date = date('Y-m-d', strtotime($request->date));
            }
        } else {
            if(!empty($request->date)) {
                $data = $data->where('date', $request->date);
                $date = date('Y-m-d', strtotime($request->date));
            } else {
                $data = $data->where('date', Carbon::now()->toDateString());
            }
            if($request->query('employee_id') != '') 
            {
                $employee_name = User::where('is_active', 1)->where('role', 'user')->where('id', $request->employee_id)->first()->full_name ?? '-';
                $data = $data->where('employee_id', $request->query('employee_id'));
            }
            if($request->query('tipe') != '') 
            {
                $data = $data->where('type', $request->query('tipe'));
            } 
    
            if($request->query('keterangan') != '') 
            {
                if($request->query('keterangan') == 'tepat_waktu') {
                    $data = $data->where('type', 'absen_biasa');
                    $data = $data->where('late', '=', null);
                }
    
                if($request->query('keterangan') == 'terlambat') {
                    $data = $data->where('type', 'absen_biasa');
                    $data = $data->where('late', '!=', null);
                }
    
                if($request->query('keterangan') == 'pulang_cepat') {
                    $data = $data->where('early_leave', '!=', null);
                }
            } 
        }
        // else 
        // {
        //     $data = $data->where('type', 'absen_biasa')->orWhere('type', 'absen_lembur');
        // }
        $data = $data->get();

        $total_terlambat = InOut::where('type', 'absen_biasa');
        if($request->date) {
            $total_terlambat = $total_terlambat->where('date', $request->date);
        } else {
            $total_terlambat = $total_terlambat->where('date', Carbon::now()->toDateString());
        }
        $total_terlambat = $total_terlambat->where('is_active', 1)->where('late', '!=', null)->count();

        
        $total_tepatwaktu = InOut::where('type', 'absen_biasa');
        if($request->date) {
            $total_tepatwaktu = $total_tepatwaktu->where('date', $request->date);
        } else {
            $total_tepatwaktu = $total_tepatwaktu->where('date', Carbon::now()->toDateString());
        }
        $total_tepatwaktu = $total_tepatwaktu->where('is_active', 1)->where('late', '=', null)->count();
        
        $total_lembur = InOut::where('type', 'absen_lembur');
        if($request->date) {
            $total_lembur = $total_lembur->where('date', $request->date);
        } else {
            $total_lembur = $total_lembur->where('date', Carbon::now()->toDateString());
        }
        $total_lembur = $total_lembur->where('is_active', 1)->count();
        
        $total_pulang_cepat = InOut::where('type', 'absen_biasa')->where('early_leave', '!=', null);
        if($request->date) {
            $total_pulang_cepat = $total_pulang_cepat->where('date', $request->date);
        } else {
            $total_pulang_cepat = $total_pulang_cepat->where('date', Carbon::now()->toDateString());
        }
        $total_pulang_cepat = $total_pulang_cepat->where('is_active', 1)->count();

        $total_belum_checkout = InOut::whereIn('type', ['absen_biasa', 'absen_lembur'])->whereNull('clock_out');
        if($request->date) {
            $total_belum_checkout = $total_belum_checkout->where('date', $request->date);
        } 
        // else {
        //     $total_belum_checkout = $total_belum_checkout->where('date', Carbon::now()->toDateString());
        // }
        $total_belum_checkout = $total_belum_checkout->where('is_active', 1)->count();



        
        
        
        $users = User::where('is_active', 1)->where('role', 'user')->orderBy('full_name', 'ASC')->get();

        $route_delete = route('adm.employee.delete');
        $route_create = route('adm.employee.create');
        return view('pages.admin.absensi.index', compact('head','data','date','route_delete','route_create','users', 'employee_name', 'total_terlambat', 'total_tepatwaktu', 'total_lembur','total_pulang_cepat', 'total_belum_checkout'));
    }

    public function detail(Request $request, $id=null) {
        $head = [
            'title' => 'Detail Presensi',
            'head_title_per_page' => "Detail Presensi",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Detail Presensi',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $data = InOut::where('is_active', 1)->where('id', $id)->first();
        $route_back = route('adm.lembur.delete');
        return view('pages.admin.absensi.detail', compact('head','data','route_back'));
    }

    public function checkoutManual(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'id' => ['required'],
            'date_out' => ['required'],
            'clock_out' => ['required']
        ]);

        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            DB::beginTransaction();

            try {

                $date_out = $request->date_out;
                $clock_out = $request->clock_out;
                $checkout_time = $date_out.' '.$clock_out.':00';

                
                $history = InOut::where(['id' => $request->id])->first();
                $user = User::where(['id' => $request->employee_id, 'is_active' => 1])->first();

                $pulang_cepat = null;
                $cek_shift = General::cekShift($user->shift ?? 1);
                if($history->type == 'absen_biasa' && strtotime($cek_shift['jam_pulang']) > strtotime(date('H:i:s'))) {
                    if($history->date == date('Y-m-d')) {
                        $pulang_cepat = date('H:i:s');
                    }
                }
                
                
                // hitung total jam kerja
                // $jam_masuk = Carbon::createFromFormat('Y-m-d H:i:s', $history->date . ' ' . $history->clock_in);
                // $jam_pulang = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($checkout_time)));
                $jam_masuk = Carbon::parse($history->date . ' ' . $history->clock_in);
                $jam_pulang = Carbon::parse(date('Y-m-d H:i:s', strtotime($checkout_time)));
                $totalWork = $jam_pulang->diffInSeconds($jam_masuk);
                
                // dd(Carbon::createFromTimestamp($totalWork)->toTimeString());
                // dd(date('H:i:s', strtotime($totalWork)));
                
                $data = [
                    'date_out' => $date_out ?? date('H:i:s'),
                    'clock_out' => $clock_out ?? date('H:i:s'),
                    'note_out' => $request->note ?? 'Checkout oleh admin, karena anda lupa men-checkout presensi sebelumnbya.',
                    'latlong_out' => null,
                    'early_leave' => $pulang_cepat ?? null,
                    'total_work' => $totalWork ?? null,
                    'overtime' =>  $history->type == 'absen_lembur' ? $totalWork : null,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];

                $last_IO = InOut::where('id', $history->id)->update($data);

                DB::commit();

                if ($last_IO) {
                    return redirect()->back()->with('success', 'Checkout Berhasil.');
                } else {
                    return redirect()->back()->with('error', 'Checkout gagal.');
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failure !' . $e);
            }
        }
    }

}
