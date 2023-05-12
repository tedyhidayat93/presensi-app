<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Helpers\General;
use Illuminate\Support\Facades\Storage;
use App\Models\{AnggotaLembur, EmployeeType,  JadwalLembur, Shift, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Image;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class LemburController extends Controller
{

    // Lemburs Admin
    public function indexLembur ($id = null) {
        $head = [
            'title' => 'Penjadwalan Lembur',
            'head_title_per_page' => "Penjadwalan Lembur",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Penjadwalan Lembur',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $data = User::orderBy('full_name', 'ASC')->where('role', 'user')->get();
        $data_lembur = JadwalLembur::orderBy('berlaku_lembur', 'DESC')->where('is_active', 1)->get();
        $route_delete = route('adm.lembur.delete');
        return view('pages.admin.lembur.index', compact('head','data_lembur','data','route_delete'));
    }

    // Lemburs Admin
    public function editLembur ($id = null) {
        $head = [
            'title' => 'Edit Jadwal Lembur',
            'head_title_per_page' => "Edit Jadwal Lembur",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Edit Jadwal Lembur',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $data = User::orderBy('full_name', 'ASC')->where('role', 'user')->get();
        $edit = JadwalLembur::where('is_active', 1)->where('id', $id)->first();
        $route_reset = route('adm.lembur.delete');
        return view('pages.admin.lembur.detail', compact('head','edit','data','route_reset'));
    }

    public function updateLembur(Request $request) {

        $jadwal  = JadwalLembur::where('id', $request->jadwal_id)->update([
            'nama_lembur' => $request->nama_lembur,
            'berlaku_lembur' => $request->berlaku_lembur,
            'updated_at' => Carbon::now()->toDateTimeString(),
            'updated_by' => auth()->user()->id
        ]);

        $anggota = [];
        if($request->usrid) {
            foreach($request->usrid as $key => $usrid) {
                array_push($anggota, [
                    'lembur_id' => $request->jadwal_id,
                    'user_id' => $usrid,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => auth()->user()->id
                ]);
            }
            AnggotaLembur::insert($anggota);
        }

        return redirect()->back()->with('success', 'Successfully update overtime schedule.');  

    }
   
    public function storeLembur(Request $request) {

        $jadwal  = JadwalLembur::create([
            'nama_lembur' => $request->nama_lembur,
            'berlaku_lembur' => $request->berlaku_lembur,
            'is_active' => 1,
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => auth()->user()->id
        ]);

        $anggota = [];
        foreach($request->usrid as $key => $usrid) {
            array_push($anggota, [
                'lembur_id' => $jadwal->id,
                'user_id' => $usrid,
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => auth()->user()->id
            ]);
        }
        AnggotaLembur::insert($anggota);

        return redirect(route('adm.lembur'))->with('success', 'Successfully create overtime schedule.');  

    }

    public function deleteLembur(Request $request) {
        try {
            JadwalLembur::where('id', $request->id)->update([
                'is_active' => 0,
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id,
            ]);
            DB::commit();
            return redirect(route('adm.lembur'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.lembur'))->with('error', 'Failure Update !');  
        }
    }

    public function deletePersonil ($id=null) {
        AnggotaLembur::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Successfully deleting personil.');  
    }

    public function exportLembur(Request $request) {
        $type = $request->type;
        if($type == 'excel') 
        {
            return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggio-'.date('d-m-Y').'.xlsx');
        } 
        else if($type == 'pdf') 
        {
            return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggio-'.date('d-m-Y').'.pdf', ExcelExcel::DOMPDF);
        } 
        else if($type == 'csv') 
        {
            return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggio-'.date('d-m-Y').'.csv', ExcelExcel::CSV);
        } 
        else 
        {
            return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
        }
    }
}
