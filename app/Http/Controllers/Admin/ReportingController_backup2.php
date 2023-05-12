<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceExport;
use App\Exports\AttendanceDetailExport;
use App\Http\Controllers\Controller;
use App\Models\{InOut, User, EmployeeType, JenisLembur, Shift};
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
        $detail_presensi = [];
        $list_user = [];
        $list_total_jenis_lembur = [];
        $dates = [];
        $log_presensi = [];
        $total_days = 0;
        $total_working_days = 0;
        $type = $req->type ?? null;
        $jenis_presensi = $req->jenis_presensi ?? null;
        $status = $req->status;
        $from_date = request()->query('from') != '' ?  request()->query('from') : null; 
        $to_date = request()->query('to') != '' ? request()->query('to') : null;
        
        $jabatan = EmployeeType::where('is_active', 1)->orderBy('type', 'ASC')->get();
        $jenis_lembur = JenisLembur::where('is_active', 1)->orderBy('type', 'ASC')->get();

        // Load data seluruh karyawan untuk reporting
        $users = User::orderBy('full_name', 'ASC')->where('is_active', 1)->where('role', 'user');
        if($type != 'all') {
            $users = $users->where('type', $type);
        }
        $users = $users->get();
        
        // untuk per rentang tanggal
        $start = Carbon::parse($from_date); 
        $end = Carbon::parse($to_date);
        setlocale(LC_TIME, 'id_ID');
    
        $tanggal2 = clone $start;
        for ($date = $tanggal2; $date->lte($end); $date->addDay()) {
            $total_days++;
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }
            $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
            array_push($dates, [
                'date' => $date->format('D'),
                'libur' => $libur_cek['libur'],
                'ket' => $libur_cek['ket'],
            ]);
        }

        // Parsing data karyawan
        foreach ($users as $usr) {

            // list data detail presensi per tanggal
            $detail_presensi[$usr->id] = [];
            // detail presensi by tanggal
            $tanggal = clone $start;
            $hari = 1;
            while ($tanggal->lte($end)) {
                $harian = InOut::where('employee_id', $usr->id);
                    if($jenis_presensi == 'absen_biasa') {
                        $harian = $harian->whereIn('type', ['absen_biasa','absen_izin']);
                    }
                    if($jenis_presensi == 'absen_lembur') {
                        $harian = $harian->whereIn('type', ['absen_lembur','absen_izin']);
                        $harian = $harian->whereNotNull('id_jenis_lembur');
                    }
                    $harian = $harian->where('date', $tanggal->format('Y-m-d'));
                    $harian = $harian->where('is_active', 1);
                    $harian = $harian->get();

                    $libur_cek = \App\Helpers\General::tanggalMerah($tanggal->format('Y-m-d'));
                    if ($libur_cek == true) {
                        $tr = 'bg-danger text-light';
                        $ket = '';
                    } else {
                        $tr = '';
                        $ket = '';
                    }

                $total_hadir = [];
                foreach ($harian as $hadir) {
                    $total_hadir[] = [
                        'in' => $hadir->clock_in ?? '-',
                        'late' => $hadir->late ?? null,
                        'izin' => $hadir->izin->alasan ?? null,
                        'id_izin' => $hadir->id_izin ?? null,
                        'jenis_lembur' => $hadir->jenisLembur->type ?? null,
                        'note_in' => $hadir->note_in ?? null,
                        'note_out' => $hadir->note_out ?? null,
                        'out' => $hadir->clock_out ?? '-',
                    ];
                }

                if($harian) {
                    // $detail_presensi[$usr->id][$hari] = $harian->clock_in;
                    $detail_presensi[$usr->id][$hari] = [
                        'td_color' => $tr,
                        'td_ket' => $ket,
                        'hari' =>  $tanggal->format('D'),
                        'tgl' =>  $tanggal->format('Y-m-d'),
                        'jam' => $total_hadir
                    ];
                } else {
                    $detail_presensi[$usr->id][$hari] = [
                        'td_color' => $tr,
                        'td_ket' => $ket,
                        'hari' =>  $tanggal->format('D'),
                        'tgl' =>  $tanggal->format('Y-m-d'),
                        'jam' => $total_hadir
                    ];      
                }

                $tanggal->addDay();
                $hari++;
            }

            
            // PARSING KALULASI KEHADIRAN
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
            $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
            $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
            
            // total telat
            $total_telat = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_telat = $total_telat->whereDate('date', '>=', $from_date);
                $total_telat = $total_telat->whereDate('date', '<=', $to_date);
            }
            $total_telat = $total_telat->whereNotNull('clock_in');
            $total_telat = $total_telat->whereNotNull('late');
            $total_telat = $total_telat->where('type', 'absen_biasa')->count();

            // total jenis lembur
            foreach($jenis_lembur as $lembur) {

                $list_total_jenis_lembur[$usr->id][$lembur->slug] = [];

                $total_hari_jenis_lembur = InOut::where('is_active', 1)->where('employee_id', $usr->id);
                if($from_date != null && $to_date != null) {
                    $total_hari_jenis_lembur = $total_hari_jenis_lembur->whereDate('date', '>=', $from_date);
                    $total_hari_jenis_lembur = $total_hari_jenis_lembur->whereDate('date', '<=', $to_date);
                }
                $total_hari_jenis_lembur = $total_hari_jenis_lembur->where('id_jenis_lembur', $lembur->id);
                $total_hari_jenis_lembur = $total_hari_jenis_lembur->whereNotNull('clock_out');
                $total_hari_jenis_lembur = $total_hari_jenis_lembur->where('type', 'absen_lembur')->count();
                
                $list_total_jenis_lembur[$usr->id][$lembur->slug] = [
                    'jenis' => $lembur->type,
                    'total' => $total_hari_jenis_lembur
                ];
                // if($total_hari_jenis_lembur) {
                // }
            
            }
         
            // total absen izin 
            $total_izin = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_izin = $total_izin->whereDate('date', '>=', $from_date);
                $total_izin = $total_izin->whereDate('date', '<=', $to_date);
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
                'kalkulasi' => [
                    'total_hari_hadir' => $total_hari_hadir,
                    'total_jam_kerja' => $total_jam_kerja,
                    'total_jam_terlambat' => $total_jam_telat,
                    'total_hari_lembur' => $total_hari_lembur,
                    'total_izin' => $total_izin,
                    'total_telat' => $total_telat,
                    'total_hari_alfa' => $total_hari_tidak_hadir ?? 0,
                    'total_jam_lembur' => $total_jam_lembur,
                    'total_jenis_lembur' => $list_total_jenis_lembur,
                ]
            ];

        }


        // dd($detail_presensi);


        return view('pages.admin.reporting.index', compact('head','start','end','data','list_user','users','detail_presensi', 'jenis_lembur', 'list_total_jenis_lembur', 'total_working_days'));


    }

    public function export(Request $req) {
        $data_bundle = [];
        $data = [];
        $tipe_file = $req->query('file_type') ?? null;
        $detail_presensi = [];
        $list_user = [];
        $list_total_jenis_lembur = [];
        $dates = [];
        $log_presensi = [];
        $total_days = 0;
        $total_working_days = 0;
        $type = $req->type ?? null;
        $jenis_presensi = $req->jenis_presensi ?? null;
        $status = $req->status;
        $from_date = request()->query('from') != '' ?  request()->query('from') : null; 
        $to_date = request()->query('to') != '' ? request()->query('to') : null;
        
        $jabatan = EmployeeType::where('is_active', 1)->orderBy('type', 'ASC')->get();
        $jenis_lembur = JenisLembur::where('is_active', 1)->orderBy('type', 'ASC')->get();

        // Load data seluruh karyawan untuk reporting
        $users = User::orderBy('full_name', 'ASC')->where('is_active', 1)->where('role', 'user');
        if($type != 'all') {
            $users = $users->where('type', $type);
        }
        $users = $users->get();
        
        // untuk per rentang tanggal
        $start = Carbon::parse($from_date); 
        $end = Carbon::parse($to_date);
        setlocale(LC_TIME, 'id_ID');
    
        $tanggal2 = clone $start;
        for ($date = $tanggal2; $date->lte($end); $date->addDay()) {
            $total_days++;
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }
            $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
            array_push($dates, [
                'date' => $date->format('D'),
                'libur' => $libur_cek['libur'],
                'ket' => $libur_cek['ket'],
            ]);
        }

        // Parsing data karyawan
        foreach ($users as $usr) {

            // list data detail presensi per tanggal
            $detail_presensi[$usr->id] = [];
            // detail presensi by tanggal
            $tanggal = clone $start;
            $hari = 1;
            while ($tanggal->lte($end)) {
                $harian = InOut::where('employee_id', $usr->id);
                    if($jenis_presensi == 'absen_biasa') {
                        $harian = $harian->whereIn('type', ['absen_biasa','absen_izin']);
                    }
                    if($jenis_presensi == 'absen_lembur') {
                        $harian = $harian->whereIn('type', ['absen_lembur','absen_izin']);
                        $harian = $harian->whereNotNull('id_jenis_lembur');
                    }
                    $harian = $harian->where('date', $tanggal->format('Y-m-d'));
                    $harian = $harian->where('is_active', 1);
                    $harian = $harian->get();

                    $libur_cek = \App\Helpers\General::tanggalMerah($tanggal->format('Y-m-d'));
                    if ($libur_cek == true) {
                        $tr = 'background:#DF2504; color:white;';
                        $ket = '';
                    } else {
                        $tr = '';
                        $ket = '';
                    }

                $total_hadir = [];
                foreach ($harian as $hadir) {
                    $total_hadir[] = [
                        'in' => $hadir->clock_in ?? '-',
                        'late' => $hadir->late ?? null,
                        'izin' => $hadir->izin->alasan ?? null,
                        'jenis_lembur' => $hadir->jenisLembur->type ?? null,
                        'note_in' => $hadir->note_in ?? null,
                        'note_out' => $hadir->note_out ?? null,
                        'out' => $hadir->clock_out ?? '-',
                    ];
                }

                if($harian) {
                    // $detail_presensi[$usr->id][$hari] = $harian->clock_in;
                    $detail_presensi[$usr->id][$hari] = [
                        'td_color' => $tr,
                        'td_ket' => $ket,
                        'hari' =>  $tanggal->format('D'),
                        'tgl' =>  $tanggal->format('Y-m-d'),
                        'jam' => $total_hadir
                    ];
                } else {
                    $detail_presensi[$usr->id][$hari] = [
                        'td_color' => $tr,
                        'td_ket' => $ket,
                        'hari' =>  $tanggal->format('D'),
                        'tgl' =>  $tanggal->format('Y-m-d'),
                        'jam' => $total_hadir
                    ];      
                }

                $tanggal->addDay();
                $hari++;
            }

            
            // PARSING KALULASI KEHADIRAN
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
            $total_hari_lembur = $total_hari_lembur->whereNotNull('clock_out');
            $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();

            // total jenis lembur
            foreach($jenis_lembur as $lembur) {

                $list_total_jenis_lembur[$usr->id][$lembur->slug] = [];

                $total_hari_jenis_lembur = InOut::where('is_active', 1)->where('employee_id', $usr->id);
                if($from_date != null && $to_date != null) {
                    $total_hari_jenis_lembur = $total_hari_jenis_lembur->whereDate('date', '>=', $from_date);
                    $total_hari_jenis_lembur = $total_hari_jenis_lembur->whereDate('date', '<=', $to_date);
                }
                $total_hari_jenis_lembur = $total_hari_jenis_lembur->where('id_jenis_lembur', $lembur->id);
                $total_hari_jenis_lembur = $total_hari_jenis_lembur->whereNotNull('clock_out');
                $total_hari_jenis_lembur = $total_hari_jenis_lembur->where('type', 'absen_lembur')->count();
                
                $list_total_jenis_lembur[$usr->id][$lembur->slug] = [
                    'jenis' => $lembur->type,
                    'total' => $total_hari_jenis_lembur
                ];
                // if($total_hari_jenis_lembur) {
                // }
            
            }
         
            // total absen izin 
            $total_izin = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_izin = $total_izin->whereDate('date', '>=', $from_date);
                $total_izin = $total_izin->whereDate('date', '<=', $to_date);
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

            // total telat
            $total_telat = InOut::where('is_active', 1)->where('employee_id', $usr->id);
            if($from_date != null && $to_date != null) {
                $total_telat = $total_telat->whereDate('date', '>=', $from_date);
                $total_telat = $total_telat->whereDate('date', '<=', $to_date);
            }
            $total_telat = $total_telat->whereNotNull('clock_in');
            $total_telat = $total_telat->whereNotNull('late');
            $total_telat = $total_telat->where('type', 'absen_biasa')->count();

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
                'kalkulasi' => [
                    'total_hari_hadir' => $total_hari_hadir,
                    'total_jam_kerja' => $total_jam_kerja,
                    'total_jam_terlambat' => $total_jam_telat,
                    'total_hari_lembur' => $total_hari_lembur,
                    'total_izin' => $total_izin,
                    'total_telat' => $total_telat,
                    'total_hari_alfa' => $total_hari_tidak_hadir ?? 0,
                    'total_jam_lembur' => $total_jam_lembur,
                    'total_jenis_lembur' => $list_total_jenis_lembur,
                ]
            ];

        }

        $data_bundle[] = [
            'tipe_pegawai'              => $type,
            'jenis_presensi'            => $jenis_presensi,
            'start'                     => $start,
            'end'                       => $end,
            'data'                      => $data,
            'list_user'                 => $list_user,
            'users'                     => $users,
            'detail_presensi'           => $detail_presensi,
            'jenis_lembur'              => $jenis_lembur,
            'list_total_jenis_lembur'   => $list_total_jenis_lembur,
            'total_working_days'        => $total_working_days
        ];

        if($tipe_file == 'excel') 
        {
            return (new AttendanceExport($data_bundle))
            ->download('laporan rekap e-kehadiran priode '. date('d-m-Y', strtotime($from_date)) .' sampai '. date('d-m-Y', strtotime($to_date)) .' dibuat tanggal '.date('d-m-Y').'.xlsx');
        } 
        else if($tipe_file == 'pdf') 
        {
            return (new AttendanceExport($data_bundle))
            ->download('laporan rekap e-kehadiran priode '. date('d-m-Y', strtotime($from_date)) .' sampai '. date('d-m-Y', strtotime($to_date)) .' dibuat tanggal '.date('d-m-Y').'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } 
        else 
        {
            return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
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
        $total_days = 0;
        $dates = [];
        $list_total_jenis_lembur = [];
        $log_presensi = [];
        $total_working_days = 0;

        $jenis_lembur = JenisLembur::where('is_active', 1)->orderBy('type', 'ASC')->get();
        $user = User::where(['id' => $user_id, 'is_active' => 1])->first();


        // untuk per rentang tanggal
        $start = Carbon::parse($from); 
        $end = Carbon::parse($to);
        setlocale(LC_TIME, 'id_ID');
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
            
            // total jenis lembur
            foreach($jenis_lembur as $lembur) {

                $list_total_jenis_lembur[$lembur->slug] = [];

                $list_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
                $list_lembur = $list_lembur->whereDate('date', $date->format('Y-m-d'));
                $list_lembur = $list_lembur->where('id_jenis_lembur', $lembur->id);
                // $list_lembur = $list_lembur->whereNotNull('clock_out');
                $list_lembur = $list_lembur->where('type', 'absen_lembur')->first();
                
                $list_total_jenis_lembur[$lembur->slug] = [
                    'jenis' => $lembur->type,
                    'in' => $list_lembur->clock_in ?? null,
                    'out' => $list_lembur->clock_out ?? null,
                    'date_out' => $list_lembur->updated_at ?? null,
                ];
            
            }

            $libur_cek = General::tanggalMerahOnline($date->format('Ymd'));
            array_push($dates, [
                // 'date' => Carbon::parse($date->format('Y-m-d'))->locale('id')->isoFormat('dddd, d MMMM Y'),
                'date' => General::dateIndo($date->format('Y-m-d')),
                'ymd' => $date->format('Y-m-d'),
                'libur' => $libur_cek['libur'],
                'ket' => $libur_cek['ket'],
                'presensi' => [
                    'harian' => [
                        'in' => $harian->clock_in ?? null,
                        'late' => $harian->late ?? '',
                        'out' => $harian->clock_out ?? null,
                    ],
                    'lembur' => $list_total_jenis_lembur
                ]
            ]);
        }

        // dd($dates);

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



        return view('pages.admin.reporting.detail', compact('head', 'total_working_days', 'total_days', 'dates', 'user', 'total_hari_hadir', 'total_alfa', 'total_telat', 'total_izin', 'total_hari_lembur', 'total_jam_telat', 'total_jam_lembur', 'total_jam_kerja','jenis_lembur'));

    }

    public function exportDetail(Request $request) {

        $data = $request->data;
       
        $user_id = $request->query('karyawan');
        $from = $request->query('from') ?? null;
        $to = $request->query('to') ?? null;

        $jenis_lembur = JenisLembur::where('is_active', 1)->orderBy('type', 'ASC')->get();
        $user = User::where(['id' => $user_id, 'is_active' => 1])->first();

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
           

            // total jenis lembur
            foreach($jenis_lembur as $lembur) {

                $list_total_jenis_lembur[$lembur->slug] = [];

                $list_lembur = InOut::where('is_active', 1)->where('employee_id', $user->id);
                $list_lembur = $list_lembur->whereDate('date', $date->format('Y-m-d'));
                $list_lembur = $list_lembur->where('id_jenis_lembur', $lembur->id);
                // $list_lembur = $list_lembur->whereNotNull('clock_out');
                $list_lembur = $list_lembur->where('type', 'absen_lembur')->first();
                
                $list_total_jenis_lembur[$lembur->slug] = [
                    'jenis' => $lembur->type,
                    'in' => $list_lembur->clock_in ?? null,
                    'out' => $list_lembur->clock_out ?? null,
                    'date_out' => $list_lembur->updated_at ?? null,
                ];
            
            }

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
                    'lembur' => $list_total_jenis_lembur
                ]
            ]);
        }

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
            'jenis_lembur' => $jenis_lembur,
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
