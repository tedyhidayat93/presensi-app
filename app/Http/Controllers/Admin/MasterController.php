<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{EmployeeType, JenisIzin, JenisLembur, Shift, Education};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MasterController extends Controller
{

    // EmployeeType
    public function indexEmployeeType ($id = null) {

        $head = [
            'title' => 'Jabatan ',
            'head_title_per_page' => "Jabatan",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Master Data',
                    'link' => '#',
                    'is_active' => false,
                ],
                [
                    'title' => 'Jabatan',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.master.store.employee.type");
            $edit = new EmployeeType;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.master.update.employee.type");
            $edit = EmployeeType::where('id', $id)->first();
        }
        $data = EmployeeType::orderBy('id', 'DESC')->where('is_active', 1)->get();
        $route_delete = route('adm.master.delete.employee.type');
        return view('pages.admin.master.employee_type.index', compact('head','method','edit','data','button_value','route','route_delete'));
    }
    public function storeEmployeeType (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'type'     => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.employee.type'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                EmployeeType::create([
                    'type' => $request->type,
                    'slug' => Str::slug($request->type),
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                return redirect(route('adm.master.employee.type'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.employee.type'))->with('error', 'Failure !');  
            }
        }
    }
    public function updateEmployeeType (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'type' => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.employee.type'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                EmployeeType::where('id', $request->id)->update([
                    'type' => $request->type,
                    'slug' => Str::slug($request->type),
                    'is_active' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
                return redirect(route('adm.master.employee.type'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.employee.type'))->with('error', 'Failure Update !');  
            }
        }
    }
    public function deleteEmployeeType (Request $request) {
        try {
            EmployeeType::where('id', $request->id)->update([
                'is_active' => 0,
                'deleted_by' => auth()->user()->id,
                'deleted_at' => now(),
            ]);
            DB::commit();
            return redirect(route('adm.master.employee.type'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.master.employee.type'))->with('error', 'Failure Update !');  
        }
    }


    // JenisIzin
    public function indexJenisIzin ($id = null) {

        $head = [
            'title' => 'Jenis Izin ',
            'head_title_per_page' => "Jenis Izin",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Master Data',
                    'link' => '#',
                    'is_active' => false,
                ],
                [
                    'title' => 'Jenis Izin',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.master.store.jenis_izin");
            $edit = new JenisIzin;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.master.update.jenis_izin");
            $edit = JenisIzin::where('id', $id)->first();
        }
        $data = JenisIzin::orderBy('id', 'DESC')->where('is_active', 1)->get();
        $route_delete = route('adm.master.delete.jenis_izin');
        return view('pages.admin.master.jenis_izin.index', compact('head','method','edit','data','button_value','route','route_delete'));
    }
    public function storeJenisIzin (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'type'     => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.jenis_izin'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                JenisIzin::create([
                    'type' => $request->type,
                    'slug' => Str::slug($request->type),
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                return redirect(route('adm.master.jenis_izin'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.jenis_izin'))->with('error', 'Failure !');  
            }
        }
    }
    public function updateJenisIzin (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'type' => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.jenis_izin'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                JenisIzin::where('id', $request->id)->update([
                    'type' => $request->type,
                    'slug' => Str::slug($request->type),
                    'is_active' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
                return redirect(route('adm.master.jenis_izin'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.jenis_izin'))->with('error', 'Failure Update !');  
            }
        }
    }
    public function deleteJenisIzin (Request $request) {
        try {
            JenisIzin::where('id', $request->id)->update([
                'is_active' => 0,
                'deleted_by' => auth()->user()->id,
                'deleted_at' => now(),
            ]);
            DB::commit();
            return redirect(route('adm.master.jenis_izin'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.master.jenis_izin'))->with('error', 'Failure Update !');  
        }
    }



    // JenisLembur
    public function indexJenisLembur ($id = null) {

        $head = [
            'title' => 'Jenis lembur ',
            'head_title_per_page' => "Jenis lembur",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Master Data',
                    'link' => '#',
                    'is_active' => false,
                ],
                [
                    'title' => 'Jenis lembur',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.master.store.jenis_lembur");
            $edit = new JenisLembur;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.master.update.jenis_lembur");
            $edit = JenisLembur::where('id', $id)->first();
        }
        $data = JenisLembur::orderBy('id', 'DESC')->where('is_active', 1)->get();
        $route_delete = route('adm.master.delete.jenis_lembur');
        return view('pages.admin.master.jenis_lembur.index', compact('head','method','edit','data','button_value','route','route_delete'));
    }
    public function storeJenisLembur (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'type'     => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.jenis_lembur'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                JenisLembur::create([
                    'type' => $request->type,
                    'slug' => Str::slug($request->type),
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                return redirect(route('adm.master.jenis_lembur'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.jenis_lembur'))->with('error', 'Failure !');  
            }
        }
    }
    public function updateJenisLembur (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'type' => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.jenis_lembur'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                JenisLembur::where('id', $request->id)->update([
                    'type' => $request->type,
                    'slug' => Str::slug($request->type),
                    'is_active' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
                return redirect(route('adm.master.jenis_lembur'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.jenis_lembur'))->with('error', 'Failure Update !');  
            }
        }
    }
    public function deleteJenisLembur (Request $request) {
        try {
            JenisLembur::where('id', $request->id)->update([
                'is_active' => 0,
                'deleted_by' => auth()->user()->id,
                'deleted_at' => now(),
            ]);
            DB::commit();
            return redirect(route('adm.master.jenis_lembur'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.master.jenis_lembur'))->with('error', 'Failure Update !');  
        }
    }


    // Education
    public function indexEducation ($id = null) {

        $head = [
            'title' => 'Jenjang Pendidikan ',
            'head_title_per_page' => "Jenjang Pendidikan",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Master Data',
                    'link' => '#',
                    'is_active' => false,
                ],
                [
                    'title' => 'Jenjang Pendidikan',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.master.store.pendidikan");
            $edit = new Education;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.master.update.pendidikan");
            $edit = Education::where('id', $id)->first();
        }
        $data = Education::orderBy('id', 'DESC')->where('is_active', 1)->get();
        $route_delete = route('adm.master.delete.pendidikan');
        return view('pages.admin.master.pendidikan.index', compact('head','method','edit','data','button_value','route','route_delete'));
    }
    public function storeEducation (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'education'     => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.pendidikan'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                Education::create([
                    'education' => $request->education,
                    'slug' => Str::slug($request->education),
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                return redirect(route('adm.master.pendidikan'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.pendidikan'))->with('error', 'Failure !');  
            }
        }
    }
    public function updateEducation (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'education' => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.master.pendidikan'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                Education::where('id', $request->id)->update([
                    'education' => $request->education,
                    'slug' => Str::slug($request->education),
                    'is_active' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
                return redirect(route('adm.master.pendidikan'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.master.pendidikan'))->with('error', 'Failure Update !');  
            }
        }
    }
    public function deleteEducation (Request $request) {
        try {
            Education::where('id', $request->id)->update([
                'is_active' => 0,
                'deleted_by' => auth()->user()->id,
                'deleted_at' => now(),
            ]);
            DB::commit();
            return redirect(route('adm.master.pendidikan'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.master.pendidikan'))->with('error', 'Failure Update !');  
        }
    }

}
