<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Helpers\General;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\Storage;
use App\Models\{Education, EmployeeType, Shift, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
// use Image;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{

    // Employees Admin
    public function indexEmployee (Request $request, $id = null) {
        $head = [
            'title' => 'Karyawan',
            'head_title_per_page' => "Karyawan",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Karyawan',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $jabatan_name = '';
        $shift_name = '';
        $data = User::orderBy('id', 'DESC')->where('role', 'user');
        if($request->status) 
        {
            $data = $data->where('status', $request->status);
            
        }
        if($request->type) 
        {
            $data = $data->where('type', $request->type);
            
        }
        
        if($request->employee_type) 
        {
            $data = $data->where('employee_type', $request->employee_type);
            $jabatan_name = EmployeeType::where('is_active', 1)->where('id', $request->employee_type)->first()->type ?? '-';
        }
        
        if($request->gender) 
        {
            $data = $data->where('gender', $request->gender);
        }
        
        if($request->shift) 
        {
            $data = $data->where('shift', $request->shift);
            $shift_name = Shift::where('is_active', 1)->where('id', $request->shift)->first()->shift_name ?? '-';
        }

        $data = $data->get();


        $jabatan = EmployeeType::where('is_active', 1)->orderBy('type', 'ASC')->get();
        $shifts = Shift::where('is_active', 1)->get();
        $total_employee = User::where(['role' => 'user', 'is_active' => 1])->count();
        $total_employee_staff = User::where(['role' => 'user', 'is_active' => 1, 'type' => 'staff'])->count();
        $total_employee_non_staff = User::where(['role' => 'user', 'is_active' => 1, 'type' => 'non_staff'])->count();
        $total_employee_tetap = User::where(['role' => 'user', 'is_active' => 1, 'status' => 'tetap'])->count();
        $total_employee_kontrak = User::where(['role' => 'user', 'is_active' => 1, 'status' => 'kontrak'])->count();
        $total_employee_magang = User::where(['role' => 'user', 'is_active' => 1, 'status' => 'magang'])->count();
        $total_employee_harian = User::where(['role' => 'user', 'is_active' => 1, 'status' => 'harian'])->count();
        $total_employee_non_active = User::where(['role' => 'user', 'is_active' => 0])->count();

        $route_delete = route('adm.employee.delete');
        $route_create = route('adm.employee.create');
        return view('pages.admin.employee.index', compact('head','data','route_delete','route_create', 'jabatan', 'shifts', 'shift_name', 'jabatan_name','total_employee','total_employee_staff','total_employee_non_staff','total_employee_non_active', 'total_employee_tetap', 'total_employee_kontrak','total_employee_magang','total_employee_harian'));
    }
    public function createEmployee () {

        $head = [
            'title' => 'Karyawan',
            'head_title_per_page' => 'Tambah Karyawan',
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Karyawan',
                    'link' => route('adm.employee'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Tambah Karyawan',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        $button_value = 'Simpan';
        $update_id = null;
        $method = '';
        $edit = new User();
        $route_back = route("adm.employee");
        $route = route("adm.employee.store");
        $images = null;
        $shifts = Shift::where('is_active', 1)->get();
        $jabatan = EmployeeType::where('is_active', 1)->get();
        $educations = Education::where('is_active', 1)->get();
        

        return view('pages.admin.employee.form', compact('head','update_id','images','edit','method','button_value','route','route_back','shifts','jabatan','educations'));
    }
    public function storeEmployee (Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [ 
            'full_name' => 'required|string|min:2|max:250',
            'nik' => 'required|string|min:2|max:17|unique:users,nik',
            'email' => 'required|string|min:2|max:250|email|unique:users,email',
            // 'password' => 'required|string|min:6|max:50',
            'shift' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.employee.create'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();      

            if($request->file('foto')) {
                $path = public_path('uploads/images/employee');
                if (!File::exists($path)) File::makeDirectory($path, 0775,true,true,true);
                $file = $request->file('foto');
                // $foto_name = time() . '_' . Str::slug($request->full_name) . '_' . trim($file->getClientOriginalName());
                $foto_name = time() . '-' . Str::slug($request->full_name) . '-' .date('YmdHis'). $file->getClientOriginalExtension();
                $file->move($path, $foto_name);
            } 

            try {

                $username = explode('@', strtolower(trim($request->email)))[0];

                $user = User::create([
                    'username' => $username,
                    'status' => $request->status,
                    'phone' => $request->phone,
                    'tanggal_masuk' => $request->tanggal_masuk,
                    'last_education' => $request->last_education,
                    'type' => $request->type,
                    'photo_profile' => $foto_name ?? null,
                    'full_name' => $request->full_name,
                    'nip' => $request->nip,
                    'nik' => $request->nik,
                    'email' => $request->email,
                    'shift' => $request->shift,
                    'employee_type' => $request->jabatan,
                    'password' => bcrypt($request->password ?? 123456789),
                    'role' => 'user',
                    'is_active' => $request->is_active,
                    'is_web' => $request->is_web != '' ? 1 : 0,
                    'is_mobile' => $request->is_mobile != '' ? 1 : 0,
                    'registered_at' => Carbon::now()->toDateTimeString(),
                ]);
            

                DB::commit();
                return redirect(route('adm.employee'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.employee.create'))->with('error', 'Failure !'.$e);  
            }
        }
    }
    public function editEmployee ($id = null) {
        $head = [
            'title' => 'Karyawan',
            'head_title_per_page' => 'Edit Karyawan',
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Karyawan',
                    'link' => route('adm.employee'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Edit Karyawan',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        $button_value = 'Edit';
        $update_id = $id;
        $method = null;
        $route_back = route("adm.employee");
        $route = route("adm.employee.update");
        $edit = User::where(['id' => $id])->first();
        $shifts = Shift::where('is_active', 1)->get();
        $educations = Education::where('is_active', 1)->get();
        $jabatan = EmployeeType::where('is_active', 1)->get();

        return view('pages.admin.employee.form', compact('head','update_id','method','edit','button_value','route','route_back','shifts','jabatan','educations'));
    }
    public function updateEmployee (Request $request) {

        if($request->old_email != $request->email) {
            $data['email'] = $request->email;
            $validator = Validator::make($request->all(), [ 
                'full_name' => 'required|string|min:2|max:250',
                'email' => 'required|string|min:2|max:250|email|unique:users,email',
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                'shift' => 'required',
                'password' => 'max:50',
            ]);
        } else {
            $validator = Validator::make($request->all(), [ 
                'full_name' => 'required|string|min:2|max:250',
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
                'shift' => 'required',
                'password' => 'max:50',
            ]);
        }

        if ($validator->fails()) {
            return redirect(route('adm.employee'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {

                $data = [
                    'full_name' => $request->full_name,
                    'status' => $request->status,
                    'phone' => $request->phone,
                    'tanggal_masuk' => $request->tanggal_masuk,
                    'last_education' => $request->last_education,
                    'type' => $request->type,
                    'gender' => $request->gender,
                    'employee_type' => $request->jabatan,
                    'shift' => $request->shift,
                    'is_active' => $request->is_active,
                    'is_web' => $request->is_web != '' ? 1 : 0,
                    'is_mobile' => $request->is_mobile != '' ? 1 : 0,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];

               
                
                if($request->old_email != $request->email) {
                    $data['email'] = $request->email;
                }

                if($request->nik) {
                    $data['nik'] = $request->nik;
                }

                if($request->nip) {
                    $data['nip'] = $request->nip;
                }

                if($request->password) {
                    $data['password'] = bcrypt($request->password);
                }

                if($request->file('foto')) {
                    $path = public_path('uploads/images/employee');
                    if (!File::exists($path)) File::makeDirectory($path, 00);
                    $file = $request->file('foto');
                    // $foto_name = time() . '_' . Str::slug($request->full_name) . '_' . trim($file->getClientOriginalName());
                    $foto_name = time() . '-' . Str::slug($request->full_name) . '-' .date('YmdHis'). $file->getClientOriginalExtension();
                    $file->move($path, $foto_name);

                    $data['photo_profile'] = $foto_name;

                } 
                
                $user = User::where('id', $request->id)->update($data);

                DB::commit();
                return redirect(route('adm.employee'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failure Update !'. $e);  
            }
        }
    }
    public function deleteEmployee (Request $request) {
        try {
            User::where('id', $request->id)->update([
                'is_active' => $request->is_active,
                'tanggal_keluar' => Carbon::now()->toDateTimeString(),
                'deactived_at' => Carbon::now()->toDateTimeString(),
            ]);
            DB::commit();
            return redirect(route('adm.employee'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.employee'))->with('error', 'Failure Update !');  
        }
    }

    public function exportEmployee(Request $request) {
        $type = $request->data;
        $from = $request->query('from_date') ?? null;
        $to = $request->query('to_date');
        $tipe = $request->query('tipe');
        $status = $request->query('status');

        if($type == 'excel') 
        {
            // return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggiollini-'.date('d-m-Y').'.xlsx');
            // return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggiollini-'.date('d-m-Y').'.xlsx');
            return (new UsersExport)
            ->status($status)
            ->tipe($tipe)
            ->fromDate($from)
            ->toDate($to)
            ->download('e-kehadiran-data-karaywan-maggio-'.date('d-m-Y').'.xlsx');
        } 
        else if($type == 'pdf') 
        {
            return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggiollini-'.date('d-m-Y').'.pdf', ExcelExcel::DOMPDF);
        } 
        else if($type == 'csv') 
        {
            return Excel::download(new UsersExport, 'e-kehadiran-data-pegawai-maggiollini-'.date('d-m-Y').'.csv', ExcelExcel::CSV);
        } 
        else 
        {
            return redirect()->back()->with('error', 'Pilih tipe export file terlebih dahulu !');
        }
    }

    public function importEmployee(Request $request) {

        $validator = Validator::make($request->all(), [ 
            'data' => 'required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator); 
        } else {
            
            Excel::import(new EmployeeImport, $request->file('data'), null);
            
            return redirect()->back()->with('success', 'Succesfully import data.');
        }
    }
}
