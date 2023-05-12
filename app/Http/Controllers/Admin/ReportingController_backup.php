<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceExport;
use App\Exports\AttendanceDetailExport;
use App\Http\Controllers\Controller;
use App\Models\{InOut, User, EmployeeType, Shift};
use Carbon\Carbon;
use App\Helpers\General;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ReportingController extends Controller
{

    public function index (Request $req) {

         // $data = InOut::leftJoin('users as u', 'u.id', 'checklock_attendance.employee_id')
        // ->select('checklock_attendance.*', 'u.id as user_id', 'u.role', 'u.type as usr_type', 'u.full_name', 'u.email', 'u.nik', 'u.nip', 'u.gender', 'u.photo_profile', 'u.shift', 'u.is_active as usr_is_active')
        // ->where('u.role', 'user')
        // ->where('u.is_active', 1);
        
        // if($from_date != null && $to_date != null) {
        //     $data = $data->whereDate('checklock_attendance.date', '>=', $from_date);
        //     $data = $data->whereDate('checklock_attendance.date', '<=', $to_date);
        // }
        // $data = $data->get();
        
        // $from_date = request()->query('from') != '' ?  date('Y-m-d', strtotime(request()->query('from'))) : null; 
        // $to_date = request()->query('to') != '' ?  date('Y-m-d', strtotime(request()->query('to'))) : null;
        $head = [
            'title' => 'Laporan ',
            'head_title_per_page' => "Laporan",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Laporan',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        $data = [];
        $list_user = [];
        $type = $req->type ?? null;
        $jenis_presensi = $req->jenis_presensi ?? null;
        $status = $req->status;
        $from_date = request()->query('from') != '' ?  request()->query('from') : null; 
        $to_date = request()->query('to') != '' ? request()->query('to') : null;


        $jabatan = EmployeeType::where('is_active', 1)->orderBy('type', 'ASC')->get();

        
        // untuk per rentang tanggal
        $start = new Carbon(request()->query('from')); 
        $end = new Carbon(request()->query('to'));
        $total_working_days = 0;
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }
        }

        // Load data seluruh karyawan untuk reporting
        $users = User::orderBy('full_name', 'ASC')->where('is_active', 1)->where('role', 'user');
        if($type != 'all') {
            $users = $users->where('type', $type);
        }

        $users = $users->get();

        // Parsing data karyawan
        foreach ($users as $usr) {

            // parsing jenis kelamin
            $gender = '-';
            if($usr->gender == 'L') {
                $gender = 'Laki-Laki';
            }elseif($usr->gender == 'P') {
                $gender = 'Perempuan';
            }else {
                $gender = 'Undefine';
            }

            // parsing foto
            if ($usr->photo_profile != null) 
            {
                $foto = asset('uploads/images/employee/'. $usr->photo_profile);
            }
            else
            {
                $foto = asset('images/default-ava.jpg');
            }

            
            // total absen harian
            $total_hari_hadir = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_hari_hadir = $total_hari_hadir->whereDate('date', '>=', $from_date);
                $total_hari_hadir = $total_hari_hadir->whereDate('date', '<=', $to_date);
            }
            if($jenis_presensi != null) {
                $total_hari_hadir = $total_hari_hadir->where('type', $jenis_presensi);
            }
            $total_hari_hadir = $total_hari_hadir->whereNotNull('clock_out');
            $total_hari_hadir = $total_hari_hadir->where('type', 'absen_biasa')->count();
                    
            // total absen lembur
            $total_hari_lembur = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_hari_lembur = $total_hari_lembur->whereDate('date', '>=', $from_date);
                $total_hari_lembur = $total_hari_lembur->whereDate('date', '<=', $to_date);
            }
            if($jenis_presensi != null) {
                $total_hari_lembur = $total_hari_lembur->where('type', $jenis_presensi);
            }
            $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
            $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
         
            // total absen izin 
            $total_izin = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_izin = $total_izin->whereDate('date', '>=', $from_date);
                $total_izin = $total_izin->whereDate('date', '<=', $to_date);
            }
            if($jenis_presensi != null) {
                $total_izin = $total_izin->where('type', $jenis_presensi);
            }
            $total_izin = $total_izin->where('type', 'absen_izin')->count();

            // Total Jam Kerja 
            $total_jam_kerja = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_jam_kerja = $total_jam_kerja->whereDate('date', '>=', $from_date);
                $total_jam_kerja = $total_jam_kerja->whereDate('date', '<=', $to_date);
            }
            if($jenis_presensi != null) {
                $total_jam_kerja = $total_jam_kerja->where('type', $jenis_presensi);
            }
            $total_jam_kerja = $total_jam_kerja->where('type', 'absen_biasa');
            $total_jam_kerja = $total_jam_kerja->whereNotNull('clock_out');
            $total_jam_kerja = $total_jam_kerja->sum('total_work');
            $total_jam_kerja = General::convertSecondToStringTime($total_jam_kerja);
            
            // Total Jam Lembur
            $total_jam_lembur = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_jam_lembur = $total_jam_lembur->whereDate('date', '>=', $from_date);
                $total_jam_lembur = $total_jam_lembur->whereDate('date', '<=', $to_date);
            }
            if($jenis_presensi != null) {
                $total_jam_lembur = $total_jam_lembur->where('type', $jenis_presensi);
            }
            $total_jam_lembur = $total_jam_lembur->where('type', 'absen_lembur');
            $total_jam_lembur = $total_jam_lembur->whereNotNull('clock_out');
            $total_jam_lembur = $total_jam_lembur->sum('overtime');
            $total_jam_lembur = General::convertSecondToStringTime($total_jam_lembur);
            
            // Total Jam Telat
            $total_jam_telat = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_jam_telat = $total_jam_telat->whereDate('date', '>=', $from_date);
                $total_jam_telat = $total_jam_telat->whereDate('date', '<=', $to_date);
            }
            if($jenis_presensi != null) {
                $total_jam_telat = $total_jam_telat->where('type', $jenis_presensi);
            }
            $total_jam_telat = $total_jam_telat->where('type', 'absen_biasa');
            $total_jam_telat = $total_jam_telat->sum('late');
            $total_jam_telat = General::convertSecondToStringTime($total_jam_telat);

            // Total tidak hadir (ALFA)
            $total_hari_tidak_hadir = (int)$total_working_days - (int)$total_hari_hadir;




            $list_user[] = [
                'usr_id' => $usr->id,
                'status' => $usr->status == 'tetap' ? 'Tetap' : 'Kontrak',
                'type' => $usr->type == 'staff' ? 'STAFF' : 'NON STAFF',
                'nik' => $usr->nik ?? null,
                'nip' => $usr->nip ?? null,
                'full_name' => $usr->full_name,
                'jabatan' => $usr->jabatan->type ?? '-',
                'gender' => $gender,
                'foto' => $foto,
                'data_absen' => [
                    'total_hari_hadir' => $total_hari_hadir,
                    'total_jam_kerja' => $total_jam_kerja,
                    'total_jam_terlambat' => $total_jam_telat,
                    'total_hari_lembur' => $total_hari_lembur,
                    'total_jam_lembur' => $total_jam_lembur,
                    'total_izin' => $total_izin,
                    'total_hari_alfa' => $total_hari_tidak_hadir ?? 0,
                ]
            ];

        }


       
        return view('pages.admin.reporting.index', compact('head','data','list_user', 'total_working_days', 'jabatan'));

    }

    public function export(Request $request) {
        $data = $request->data;
        $tipe = $request->query('type');
        $status = $request->query('status');
        $from = $request->query('from') ?? null;
        $to = $request->query('to') ?? null;
        $method = $request->query('method') ?? null;

        if($method == 'single') {
            if($data == 'excel') 
            {
                return (new AttendanceExport)
                ->status($status)
                ->tipe($tipe)
                ->fromDate($from)
                ->toDate($to)
                ->download('e-kehadiran-data-karaywan-maggio-'.date('d-m-Y').'.xlsx');
            } 
            else if($data == 'pdf') 
            {
                return (new AttendanceExport)
                ->status($status)
                ->tipe($tipe)
                ->fromDate($from)
                ->toDate($to)
                ->download('e-kehadiran-data-karaywan-maggio-'.date('d-m-Y').'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            } 
            else 
            {
                return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
            }
        } else if($method == 'bulk') { 
       
            $data = $request->data; //jenis export excel or pdf
       
            $user_id = $request->query('karyawan');


            $karyawan = User::where('role', 'user')->where('is_active',1)->get();

            foreach ($karyawan as $usr) {

                $from = $request->query('from') ?? null;
                $to = $request->query('to') ?? null;

            }
            
            



            $start = Carbon::parse($from); 
            $end = Carbon::parse($to);
            setlocale(LC_TIME, 'id_ID');

            $total_days = 0;
            $dates = [];
            $log_presensi = [];
            $total_working_days = 0;
            // untuk per rentang tanggal
            for ($date = $start; $date->lte($end); $date->addDay()) {
                $total_days++;
                if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                    $total_working_days++;
                }

                $harian = InOut::where('date', $date->format('Y-m-d'))
                    ->where('type', 'absen_biasa')
                    ->where('is_active', 1)
                    ->whereNull('id_jenis_lembur') 
                    ->where('employee_id', $user_id)
                    ->first();
                $operan_malam = InOut::where('date', $date->format('Y-m-d'))
                    ->where('type', 'absen_lembur')
                    ->where('id_jenis_lembur', 1) 
                    ->where('is_active', 1)
                    ->where('employee_id', $user_id)
                    ->first();
                $operan_pagi = InOut::where('date', $date->format('Y-m-d'))
                    ->where('type', 'absen_lembur')
                    ->where('id_jenis_lembur', 2) 
                    ->where('is_active', 1)
                    ->where('employee_id', $user_id)
                    ->first();
                $lembur_workshop = InOut::where('date', $date->format('Y-m-d'))
                    ->where('type', 'absen_lembur')
                    ->where('id_jenis_lembur', 3) 
                    ->where('is_active', 1)
                    ->where('employee_id', $user_id)
                    ->first();

                $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
                array_push($dates, [
                    // 'date' => Carbon::parse($date->format('Y-m-d'))->locale('id')->isoFormat('dddd, d MMMM Y'),
                    'date' => General::dateIndo($date->format('Y-m-d')),
                    'libur' => $libur_cek['libur'],
                    'ket' => $libur_cek['ket'],
                    'presensi' => [
                        'harian' => [
                            'in' => $harian->clock_in ?? null,
                            'late' => $harian->late ?? null,
                            'is_auto_checkout_daily' => $harian->is_auto_checkout_daily ?? 0,
                            'out' => $harian->clock_out ?? null,
                        ],
                        'operan_malam' => [
                            'in' => $operan_malam->clock_in ?? null,
                            'out' => $operan_malam->clock_out ?? null,
                            'date_out' => $operan_malam->updated_at ?? null,
                        ],
                        'operan_pagi' => [
                            'in' => $operan_pagi->clock_in ?? null,
                            'out' => $operan_pagi->clock_out ?? null,
                            'date_out' => $operan_pagi->updated_at ?? null,
                        ],
                        'lembur_workshop' => [
                            'in' => $lembur_workshop->clock_in ?? null,
                            'out' => $lembur_workshop->clock_out ?? null,
                            'date_out' => $lembur_workshop->updated_at ?? null,
                        ],
                    ]
                ]);
            }

            // Detail akumulatif data per rentang tanggal
            $user = User::where(['id' => $user_id, 'is_active' => 1])->first();

            // total absen harian
            $total_hari_hadir = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_hari_hadir = $total_hari_hadir->whereDate('date', '>=', $from);
                $total_hari_hadir = $total_hari_hadir->whereDate('date', '<=', $to);
            }
            $total_hari_hadir = $total_hari_hadir->whereNotNull('clock_out');
            $total_hari_hadir = $total_hari_hadir->where('type', 'absen_biasa')->count();
                    
            // total absen lembur
            $total_hari_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_hari_lembur = $total_hari_lembur->whereDate('date', '>=', $from);
                $total_hari_lembur = $total_hari_lembur->whereDate('date', '<=', $to);
            }
            $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
            $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
        
            // total absen izin 
            $total_izin = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_izin = $total_izin->whereDate('date', '>=', $from);
                $total_izin = $total_izin->whereDate('date', '<=', $to);
            }
            $total_izin = $total_izin->where('type', 'absen_izin')->count();

            // Total Telat
            $total_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_telat = $total_telat->whereDate('date', '>=', $from);
                $total_telat = $total_telat->whereDate('date', '<=', $to);
            }
            $total_telat = $total_telat->whereNotNull('late');
            $total_telat = $total_telat->where('type', 'absen_biasa');
            $total_telat = $total_telat->count();

            // Total tidak hadir (ALFA)
            $total_alfa = (int)$total_working_days - (int)$total_hari_hadir;

            // Total Jam Kerja 
            $total_jam_kerja = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_jam_kerja = $total_jam_kerja->whereDate('date', '>=', $from);
                $total_jam_kerja = $total_jam_kerja->whereDate('date', '<=', $to);
            }
            $total_jam_kerja = $total_jam_kerja->where('type', 'absen_biasa');
            $total_jam_kerja = $total_jam_kerja->whereNotNull('clock_out');
            $total_jam_kerja = $total_jam_kerja->sum('total_work');
            $total_jam_kerja = General::convertSecondToStringTime($total_jam_kerja);
            
            // Total Jam Lembur
            $total_jam_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_jam_lembur = $total_jam_lembur->whereDate('date', '>=', $from);
                $total_jam_lembur = $total_jam_lembur->whereDate('date', '<=', $to);
            }
            $total_jam_lembur = $total_jam_lembur->where('type', 'absen_lembur');
            $total_jam_lembur = $total_jam_lembur->whereNotNull('clock_out');
            $total_jam_lembur = $total_jam_lembur->sum('overtime');
            $total_jam_lembur = General::convertSecondToStringTime($total_jam_lembur);
            
            // Total Jam Telat
            $total_jam_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
            if($from != null && $to != null) {
                $total_jam_telat = $total_jam_telat->whereDate('date', '>=', $from);
                $total_jam_telat = $total_jam_telat->whereDate('date', '<=', $to);
            }
            $total_jam_telat = $total_jam_telat->where('type', 'absen_biasa');
            $total_jam_telat = $total_jam_telat->sum('late');
            $total_jam_telat = General::convertSecondToStringTime($total_jam_telat);


            $log_presensi[] = [

                'from_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $from)->isoFormat('D MMMM Y'),
                'to_date' =>\Carbon\Carbon::createFromFormat('Y-m-d', $to)->isoFormat('D MMMM Y'),
                
                'total_working_days' => $total_working_days,
                'total_days' => $total_days,
                'user' => $user,
                'total_hari_hadir' => $total_hari_hadir,
                'total_alfa' => $total_alfa,
                'total_telat' => $total_telat,
                'total_izin' => $total_izin,
                'total_hari_lembur' => $total_hari_lembur,
                'total_jam_telat' => $total_jam_telat,
                'total_jam_lembur' => $total_jam_lembur,
                'total_jam_kerja' => $total_jam_kerja,
                'dates' => $dates
            ];

            // dd($log_presensi);

            if($data == 'excel') 
            {
                return (new AttendanceDetailExport($log_presensi))
                ->download('e-kehadiran-data-'. Str::slug($user->full_name) .'-'.date('d-m-Y').'.xlsx');
            } 
            else if($data == 'pdf') 
            {
                return (new AttendanceDetailExport($log_presensi))
                ->download('e-kehadiran-data-'. Str::slug($user->full_name) .'-'.date('d-m-Y').'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            } 
            else 
            {
                return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
            }
        }
        
    }
    
    public function detailReportPerKaryawan (Request $request) {
        $head = [
            'title' => 'Laporan Detail',
            'head_title_per_page' => "Laporan Detail",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Laporan',
                    'link' => route('adm.report'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Detail Laporan',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];
        $user_id = $request->query('karyawan');
        $from = $request->query('from_date') ?? null;
        $to = $request->query('to_date') ?? null;

        // untuk per rentang tanggal
        $start = Carbon::parse($from); 
        $end = Carbon::parse($to);
        setlocale(LC_TIME, 'id_ID');
        $total_days = 0;
        $dates = [];
        $log_presensi = [];
        $total_working_days = 0;
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $total_days++;
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }

            $harian = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_biasa')
                ->where('is_active', 1)
                ->whereNull('id_jenis_lembur') 
                ->where('employee_id', $user_id)
                ->first();
            $operan_malam = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 1) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();
            $operan_pagi = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 2) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();
            $lembur_workshop = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 3) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();

            $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
            array_push($dates, [
                // 'date' => Carbon::parse($date->format('Y-m-d'))->locale('id')->isoFormat('dddd, d MMMM Y'),
                'date' => General::dateIndo($date->format('Y-m-d')),
                'libur' => $libur_cek['libur'],
                'ket' => $libur_cek['ket'],
                'presensi' => [
                    'harian' => [
                        'in' => $harian->clock_in ?? null,
                        'late' => $harian->late ?? '',
                        'out' => $harian->clock_out ?? null,
                    ],
                    'operan_malam' => [
                        'in' => $operan_malam->clock_in ?? null,
                        'out' => $operan_malam->clock_out ?? null,
                        'date_out' => $operan_malam->updated_at ?? null,
                    ],
                    'operan_pagi' => [
                        'in' => $operan_pagi->clock_in ?? null,
                        'out' => $operan_pagi->clock_out ?? null,
                        'date_out' => $operan_pagi->updated_at ?? null,
                    ],
                    'lembur_workshop' => [
                        'in' => $lembur_workshop->clock_in ?? null,
                        'out' => $lembur_workshop->clock_out ?? null,
                        'date_out' => $lembur_workshop->updated_at ?? null,
                    ],
                ]
            ]);
        }

        $user = User::where(['id' => $user_id, 'is_active' => 1])->first();

        // total absen harian
        $total_hari_hadir = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '>=', $from);
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '<=', $to);
        }
        $total_hari_hadir = $total_hari_hadir->whereNotNull('clock_out');
        $total_hari_hadir = $total_hari_hadir->where('type', 'absen_biasa')->count();
                
        // total absen lembur
        $total_hari_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '>=', $from);
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '<=', $to);
        }
        $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
        $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
     
        // total absen izin 
        $total_izin = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_izin = $total_izin->whereDate('date', '>=', $from);
            $total_izin = $total_izin->whereDate('date', '<=', $to);
        }
        $total_izin = $total_izin->where('type', 'absen_izin')->count();

        // Total Telat
        $total_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_telat = $total_telat->whereDate('date', '>=', $from);
            $total_telat = $total_telat->whereDate('date', '<=', $to);
        }
        $total_telat = $total_telat->whereNotNull('late');
        $total_telat = $total_telat->where('type', 'absen_biasa');
        $total_telat = $total_telat->count();

        // Total tidak hadir (ALFA)
        $total_alfa = (int)$total_working_days - (int)$total_hari_hadir;

        // Total Jam Kerja 
        $total_jam_kerja = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '>=', $from);
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '<=', $to);
        }
        $total_jam_kerja = $total_jam_kerja->where('type', 'absen_biasa');
        $total_jam_kerja = $total_jam_kerja->whereNotNull('clock_out');
        $total_jam_kerja = $total_jam_kerja->sum('total_work');
        $total_jam_kerja = General::convertSecondToStringTime($total_jam_kerja);
        
        // Total Jam Lembur
        $total_jam_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '>=', $from);
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '<=', $to);
        }
        $total_jam_lembur = $total_jam_lembur->where('type', 'absen_lembur');
        $total_jam_lembur = $total_jam_lembur->whereNotNull('clock_out');
        $total_jam_lembur = $total_jam_lembur->sum('overtime');
        $total_jam_lembur = General::convertSecondToStringTime($total_jam_lembur);
        
        // Total Jam Telat
        $total_jam_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_telat = $total_jam_telat->whereDate('date', '>=', $from);
            $total_jam_telat = $total_jam_telat->whereDate('date', '<=', $to);
        }
        $total_jam_telat = $total_jam_telat->where('type', 'absen_biasa');
        $total_jam_telat = $total_jam_telat->sum('late');
        $total_jam_telat = General::convertSecondToStringTime($total_jam_telat);



        return view('pages.admin.reporting.detail', compact('head', 'total_working_days', 'total_days', 'dates', 'user', 'total_hari_hadir', 'total_alfa', 'total_telat', 'total_izin', 'total_hari_lembur', 'total_jam_telat', 'total_jam_lembur', 'total_jam_kerja'));

    }

    public function exportDetail(Request $request) {

        $data = $request->data;
       
        $user_id = $request->query('karyawan');
        $from = $request->query('from') ?? null;
        $to = $request->query('to') ?? null;


        $start = Carbon::parse($from); 
        $end = Carbon::parse($to);
        setlocale(LC_TIME, 'id_ID');

        $total_days = 0;
        $dates = [];
        $log_presensi = [];
        $total_working_days = 0;
        // untuk per rentang tanggal
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $total_days++;
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }

            $harian = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_biasa')
                ->where('is_active', 1)
                ->whereNull('id_jenis_lembur') 
                ->where('employee_id', $user_id)
                ->first();
            $operan_malam = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 1) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();
            $operan_pagi = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 2) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();
            $lembur_workshop = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 3) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();

            $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
            array_push($dates, [
                // 'date' => Carbon::parse($date->format('Y-m-d'))->locale('id')->isoFormat('dddd, d MMMM Y'),
                'date' => General::dateIndo($date->format('Y-m-d')),
                'libur' => $libur_cek['libur'],
                'ket' => $libur_cek['ket'],
                'presensi' => [
                    'harian' => [
                        'in' => $harian->clock_in ?? null,
                        'late' => $harian->late ?? null,
                        'is_auto_checkout_daily' => $harian->is_auto_checkout_daily ?? 0,
                        'out' => $harian->clock_out ?? null,
                    ],
                    'operan_malam' => [
                        'in' => $operan_malam->clock_in ?? null,
                        'out' => $operan_malam->clock_out ?? null,
                        'date_out' => $operan_malam->updated_at ?? null,
                    ],
                    'operan_pagi' => [
                        'in' => $operan_pagi->clock_in ?? null,
                        'out' => $operan_pagi->clock_out ?? null,
                        'date_out' => $operan_pagi->updated_at ?? null,
                    ],
                    'lembur_workshop' => [
                        'in' => $lembur_workshop->clock_in ?? null,
                        'out' => $lembur_workshop->clock_out ?? null,
                        'date_out' => $lembur_workshop->updated_at ?? null,
                    ],
                ]
            ]);
        }

        // Detail akumulatif data per rentang tanggal
        $user = User::where(['id' => $user_id, 'is_active' => 1])->first();

        // total absen harian
        $total_hari_hadir = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '>=', $from);
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '<=', $to);
        }
        $total_hari_hadir = $total_hari_hadir->whereNotNull('clock_out');
        $total_hari_hadir = $total_hari_hadir->where('type', 'absen_biasa')->count();
                
        // total absen lembur
        $total_hari_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '>=', $from);
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '<=', $to);
        }
        $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
        $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
     
        // total absen izin 
        $total_izin = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_izin = $total_izin->whereDate('date', '>=', $from);
            $total_izin = $total_izin->whereDate('date', '<=', $to);
        }
        $total_izin = $total_izin->where('type', 'absen_izin')->count();

        // Total Telat
        $total_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_telat = $total_telat->whereDate('date', '>=', $from);
            $total_telat = $total_telat->whereDate('date', '<=', $to);
        }
        $total_telat = $total_telat->whereNotNull('late');
        $total_telat = $total_telat->where('type', 'absen_biasa');
        $total_telat = $total_telat->count();

        // Total tidak hadir (ALFA)
        $total_alfa = (int)$total_working_days - (int)$total_hari_hadir;

        // Total Jam Kerja 
        $total_jam_kerja = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '>=', $from);
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '<=', $to);
        }
        $total_jam_kerja = $total_jam_kerja->where('type', 'absen_biasa');
        $total_jam_kerja = $total_jam_kerja->whereNotNull('clock_out');
        $total_jam_kerja = $total_jam_kerja->sum('total_work');
        $total_jam_kerja = General::convertSecondToStringTime($total_jam_kerja);
        
        // Total Jam Lembur
        $total_jam_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '>=', $from);
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '<=', $to);
        }
        $total_jam_lembur = $total_jam_lembur->where('type', 'absen_lembur');
        $total_jam_lembur = $total_jam_lembur->whereNotNull('clock_out');
        $total_jam_lembur = $total_jam_lembur->sum('overtime');
        $total_jam_lembur = General::convertSecondToStringTime($total_jam_lembur);
        
        // Total Jam Telat
        $total_jam_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_telat = $total_jam_telat->whereDate('date', '>=', $from);
            $total_jam_telat = $total_jam_telat->whereDate('date', '<=', $to);
        }
        $total_jam_telat = $total_jam_telat->where('type', 'absen_biasa');
        $total_jam_telat = $total_jam_telat->sum('late');
        $total_jam_telat = General::convertSecondToStringTime($total_jam_telat);


        $log_presensi[] = [

            'from_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $from)->isoFormat('D MMMM Y'),
            'to_date' =>\Carbon\Carbon::createFromFormat('Y-m-d', $to)->isoFormat('D MMMM Y'),
            
            'total_working_days' => $total_working_days,
            'total_days' => $total_days,
            'user' => $user,
            'total_hari_hadir' => $total_hari_hadir,
            'total_alfa' => $total_alfa,
            'total_telat' => $total_telat,
            'total_izin' => $total_izin,
            'total_hari_lembur' => $total_hari_lembur,
            'total_jam_telat' => $total_jam_telat,
            'total_jam_lembur' => $total_jam_lembur,
            'total_jam_kerja' => $total_jam_kerja,
            'dates' => $dates
        ];

        // dd($log_presensi);

        if($data == 'excel') 
        {
            return (new AttendanceDetailExport($log_presensi))
            ->download('e-kehadiran-data-'. Str::slug($user->full_name) .'-'.date('d-m-Y').'.xlsx');
        } 
        else if($data == 'pdf') 
        {
            return (new AttendanceDetailExport($log_presensi))
            ->download('e-kehadiran-data-'. Str::slug($user->full_name) .'-'.date('d-m-Y').'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } 
        else 
        {
            return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
        }
    }

    private function exportDetailBulk(Request $request) {

        $data = $request->data;
       
        $user_id = $request->query('karyawan');
        $from = $request->query('from') ?? null;
        $to = $request->query('to') ?? null;


        $start = Carbon::parse($from); 
        $end = Carbon::parse($to);
        setlocale(LC_TIME, 'id_ID');

        $total_days = 0;
        $dates = [];
        $log_presensi = [];
        $total_working_days = 0;
        // untuk per rentang tanggal
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $total_days++;
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }

            $harian = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_biasa')
                ->where('is_active', 1)
                ->whereNull('id_jenis_lembur') 
                ->where('employee_id', $user_id)
                ->first();
            $operan_malam = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 1) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();
            $operan_pagi = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 2) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();
            $lembur_workshop = InOut::where('date', $date->format('Y-m-d'))
                ->where('type', 'absen_lembur')
                ->where('id_jenis_lembur', 3) 
                ->where('is_active', 1)
                ->where('employee_id', $user_id)
                ->first();

            $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
            array_push($dates, [
                // 'date' => Carbon::parse($date->format('Y-m-d'))->locale('id')->isoFormat('dddd, d MMMM Y'),
                'date' => General::dateIndo($date->format('Y-m-d')),
                'libur' => $libur_cek['libur'],
                'ket' => $libur_cek['ket'],
                'presensi' => [
                    'harian' => [
                        'in' => $harian->clock_in ?? null,
                        'late' => $harian->late ?? null,
                        'is_auto_checkout_daily' => $harian->is_auto_checkout_daily ?? 0,
                        'out' => $harian->clock_out ?? null,
                    ],
                    'operan_malam' => [
                        'in' => $operan_malam->clock_in ?? null,
                        'out' => $operan_malam->clock_out ?? null,
                        'date_out' => $operan_malam->updated_at ?? null,
                    ],
                    'operan_pagi' => [
                        'in' => $operan_pagi->clock_in ?? null,
                        'out' => $operan_pagi->clock_out ?? null,
                        'date_out' => $operan_pagi->updated_at ?? null,
                    ],
                    'lembur_workshop' => [
                        'in' => $lembur_workshop->clock_in ?? null,
                        'out' => $lembur_workshop->clock_out ?? null,
                        'date_out' => $lembur_workshop->updated_at ?? null,
                    ],
                ]
            ]);
        }

        // Detail akumulatif data per rentang tanggal
        $user = User::where(['id' => $user_id, 'is_active' => 1])->first();

        // total absen harian
        $total_hari_hadir = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '>=', $from);
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '<=', $to);
        }
        $total_hari_hadir = $total_hari_hadir->whereNotNull('clock_out');
        $total_hari_hadir = $total_hari_hadir->where('type', 'absen_biasa')->count();
                
        // total absen lembur
        $total_hari_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '>=', $from);
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '<=', $to);
        }
        $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
        $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
     
        // total absen izin 
        $total_izin = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_izin = $total_izin->whereDate('date', '>=', $from);
            $total_izin = $total_izin->whereDate('date', '<=', $to);
        }
        $total_izin = $total_izin->where('type', 'absen_izin')->count();

        // Total Telat
        $total_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_telat = $total_telat->whereDate('date', '>=', $from);
            $total_telat = $total_telat->whereDate('date', '<=', $to);
        }
        $total_telat = $total_telat->whereNotNull('late');
        $total_telat = $total_telat->where('type', 'absen_biasa');
        $total_telat = $total_telat->count();

        // Total tidak hadir (ALFA)
        $total_alfa = (int)$total_working_days - (int)$total_hari_hadir;

        // Total Jam Kerja 
        $total_jam_kerja = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '>=', $from);
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '<=', $to);
        }
        $total_jam_kerja = $total_jam_kerja->where('type', 'absen_biasa');
        $total_jam_kerja = $total_jam_kerja->whereNotNull('clock_out');
        $total_jam_kerja = $total_jam_kerja->sum('total_work');
        $total_jam_kerja = General::convertSecondToStringTime($total_jam_kerja);
        
        // Total Jam Lembur
        $total_jam_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '>=', $from);
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '<=', $to);
        }
        $total_jam_lembur = $total_jam_lembur->where('type', 'absen_lembur');
        $total_jam_lembur = $total_jam_lembur->whereNotNull('clock_out');
        $total_jam_lembur = $total_jam_lembur->sum('overtime');
        $total_jam_lembur = General::convertSecondToStringTime($total_jam_lembur);
        
        // Total Jam Telat
        $total_jam_telat = InOut::where('is_active', 1)->where('employee_id', $user->id);
        if($from != null && $to != null) {
            $total_jam_telat = $total_jam_telat->whereDate('date', '>=', $from);
            $total_jam_telat = $total_jam_telat->whereDate('date', '<=', $to);
        }
        $total_jam_telat = $total_jam_telat->where('type', 'absen_biasa');
        $total_jam_telat = $total_jam_telat->sum('late');
        $total_jam_telat = General::convertSecondToStringTime($total_jam_telat);


        $log_presensi[] = [

            'from_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $from)->isoFormat('D MMMM Y'),
            'to_date' =>\Carbon\Carbon::createFromFormat('Y-m-d', $to)->isoFormat('D MMMM Y'),
            
            'total_working_days' => $total_working_days,
            'total_days' => $total_days,
            'user' => $user,
            'total_hari_hadir' => $total_hari_hadir,
            'total_alfa' => $total_alfa,
            'total_telat' => $total_telat,
            'total_izin' => $total_izin,
            'total_hari_lembur' => $total_hari_lembur,
            'total_jam_telat' => $total_jam_telat,
            'total_jam_lembur' => $total_jam_lembur,
            'total_jam_kerja' => $total_jam_kerja,
            'dates' => $dates
        ];

        // dd($log_presensi);

        if($data == 'excel') 
        {
            return (new AttendanceDetailExport($log_presensi))
            ->download('e-kehadiran-data-'. Str::slug($user->full_name) .'-'.date('d-m-Y').'.xlsx');
        } 
        else if($data == 'pdf') 
        {
            return (new AttendanceDetailExport($log_presensi))
            ->download('e-kehadiran-data-'. Str::slug($user->full_name) .'-'.date('d-m-Y').'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } 
        else 
        {
            return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
        }
    }

}
