<?php

namespace App\Http\Controllers\Admin;

use App\Exports\IzinsExport;
use App\Http\Controllers\Controller;
use App\Helpers\General;
use Illuminate\Support\Facades\Storage;
use App\Models\{EmployeeType, InOut, JenisIzin, Shift, Izin, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
// use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class IzinController extends Controller
{

    // Izins Admin
    // public function indexIzin ($id = null, Request $request) {
    public function indexIzin (Request $request) {
        // dd($request->query('status'));
        $head = [
            'title' => 'Data Izin',
            'head_title_per_page' => "Data Izin",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Data Izin',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $nama_jenis_izin = '';
        $nama_user = '';
        $from = request()->query('from') != '' ?  date('Y-m-d', strtotime(request()->query('from'))) : null; 
        $to = request()->query('to') != '' ?  date('Y-m-d', strtotime(request()->query('to'))) : null;

        $data = Izin::orderBy('is_approve', 'ASC')->orderBy('created_at', 'DESC')->where('is_active', 1);
        if($request->query('status')) 
        {
            $data = $data->where('is_approve', $request->query('status'));
        }
        
        if($request->query('jenis_izin_id')) 
        {
            $data = $data->where('jenis_izin_id', $request->query('jenis_izin_id'));
            $nama_jenis_izin = JenisIzin::where('is_active', 1)->where('id', $request->jenis_izin_id)->first()->type ?? '-';
        }
        
        if($request->query('created_by')) 
        {
            $data = $data->where('created_by', $request->query('created_by'));
            $nama_user = User::where('is_active', 1)->where('role', 'user')->where('id', $request->created_by)->first()->full_name ?? '-';
        }
        if($from != null && $to != null) {
            $data = $data->whereDate('created_at', '>=', $from);
            $data = $data->whereDate('created_at', '<=', $to);
        }
        $data = $data->get();
       

        $jabatan = EmployeeType::where('is_active', 1)->orderBy('type', 'ASC')->get();
        $shifts = Shift::where('is_active', 1)->get();

        // dd($data);
        $jenis_izin = JenisIzin::where('is_active', 1)->get();
        $users = User::where('is_active', 1)->where('role', 'user')->orderBy('full_name', 'ASC')->get();

        $total_all = Izin::where('is_active', 1)->count();
        $total_menunggu = Izin::where('is_active', 1)->where('is_approve', 1)->count();
        $total_disetujui = Izin::where('is_active', 1)->where('is_approve', 2)->count();
        $total_ditolak = Izin::where('is_active', 1)->where('is_approve', 3)->count();


        return view('pages.admin.izin.index', compact('head','data', 'jenis_izin', 'nama_jenis_izin', 'users', 'nama_user', 'total_menunggu', 'total_disetujui', 'total_all', 'total_ditolak', 'jabatan', 'shifts'));
    }
    
    public function detail ($id = null) {
        $head = [
            'title' => 'Detail Izin',
            'head_title_per_page' => 'Detail Izin',
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Detail Izin',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        $data = Izin::where(['id' => $id, 'is_active' => 1])->first();

        return view('pages.admin.izin.detail', compact('head','data'));
    }
    
    public function accIzin (Request $request) {
        try {
            $izin = Izin::where('id', $request->id)->where('is_active', 1)->update([
                'is_approve' => $request->query('act'),
                'validation_at' => Carbon::now()->toDateTimeString(),
                'validation_by' => auth()->user()->id,
            ]);

            DB::commit();
            return redirect(route('adm.izin'))->with('success', 'Successfully Update data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.izin'))->with('error', 'Failure Update !', $e);  
        }
    }

    public function exportIzin(Request $request) {
        $type = $request->type;
        if($type == 'excel') 
        {
            return Excel::download(new IzinsExport, 'e-kehadiran-data-pegawai-maggio-'.date('d-m-Y').'.xlsx');
        } 
        else if($type == 'pdf') 
        {
            return Excel::download(new IzinsExport, 'e-kehadiran-data-pegawai-maggio-'.date('d-m-Y').'.pdf', ExcelExcel::DOMPDF);
        } 
        else if($type == 'csv') 
        {
            return Excel::download(new IzinsExport, 'e-kehadiran-data-pegawai-maggio-'.date('d-m-Y').'.csv', ExcelExcel::CSV);
        } 
        else 
        {
            return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
        }
    }
}
