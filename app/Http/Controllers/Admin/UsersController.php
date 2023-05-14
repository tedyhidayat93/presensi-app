<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\General;
use Illuminate\Support\Facades\Hash;
use App\Models\{User};
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Image;
use Intervention\Image\ImageManagerStatic as Image;

class UsersController extends Controller
{

    // Users Admin
    public function indexUser ($id = null) {
        $head = [
            'title' => 'User Admin',
            'head_title_per_page' => "User Admin",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'User Admin',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];
        $data = User::orderBy('id', 'DESC')->where('role', '!=', 'superadmin')->where('role','!=','user')->get();
        $route_delete = route('adm.users.delete');
        $route_create = route('adm.users.create');
        return view('pages.admin.users.index', compact('head','data','route_delete','route_create'));
    }
    public function createUser () {

        $head = [
            'title' => 'User Admin',
            'head_title_per_page' => 'Tambah Admin',
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'User Admin',
                    'link' => route('adm.users'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Edit User',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        $button_value = 'Simpan';
        $update_id = null;
        $method = '';
        $edit = new User();
        $route_back = route("adm.users");
        $route = route("adm.users.store");
        $images = null;
        return view('pages.admin.users.form', compact('head','update_id','images','edit','method','button_value','route','route_back'));
    }
    public function storeUser (Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [ 
            'full_name' => 'required|string|min:2|max:250',
            'email' => 'required|string|min:2|max:250|email|unique:users,email',
            'password' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.users.create'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                if($request->file('foto')) {
                    $path = public_path('uploads/images/admin');
                    if (!File::exists($path)) File::makeDirectory($path, 0775,true,true,true);
                    $file = $request->file('foto');
                    // $foto_name = time() . '_' . Str::slug($request->full_name) . '_' . trim($file->getClientOriginalName());
                    $foto_name = time() . '-' . Str::slug($request->full_name) . '-' .date('YmdHis'). $file->getClientOriginalExtension();
                    $file->move($path, $foto_name);
                } 
                $username = explode('@', $request->email)[0];
                $user = User::create([
                    'username' => $username,
                    'full_name' => $request->full_name,
                    'photo_profile' => $foto_name ?? null,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'admin',
                    'is_active' => $request->is_active,
                    'registered_at' => Carbon::now()->toDateTimeString(),
                ]);
            

                DB::commit();
                return redirect(route('adm.users'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.users.create'))->with('error', 'Failure !'.$e);  
            }
        }
    }
    public function editUser ($id = null) {
        $head = [
            'title' => 'User Admin',
            'head_title_per_page' => 'Edit Admin',
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'User Admin',
                    'link' => route('adm.users'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Edit User',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        $button_value = 'Edit';
        $update_id = $id;
        $method = null;
        $route_back = route("adm.users");
        $route = route("adm.users.update");
        $edit = User::where(['id' => $id])->first();

        return view('pages.admin.users.form', compact('head','update_id','method','edit','button_value','route','route_back'));
    }
    public function updateUser (Request $request) {
        // dd($request->file('foto'));

        $validator = Validator::make($request->all(), [ 
            'full_name' => 'required|string|min:2|max:250',
            'password' => 'max:50',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.users'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {

                $data = [
                    'full_name' => $request->full_name,
                    'is_active' => $request->is_active,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
                if($request->password) {
                    $data['password'] = Hash::make($request->password);
                }

                if($request->file('foto')) {
                    $path = public_path('uploads/images/admin');
                    if (!File::exists($path)) File::makeDirectory($path, 775);
                    $file = $request->file('foto');
                    // $foto_name = time() . '_' . Str::slug($request->full_name) . '_' . trim($file->getClientOriginalName());
                    $foto_name = time() . '-' . Str::slug($request->full_name) . '-' .date('YmdHis'). $file->getClientOriginalExtension();
                    $file->move($path, $foto_name);

                    $data['photo_profile'] = $foto_name;

                } 

                $user = User::where('id', $request->id)->update($data);

                DB::commit();
                return redirect(route('adm.users'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failure Update !');  
            }
        }
    }
    public function deleteUser (Request $request) {
        try {
            User::where('id', $request->id)->update([
                'is_active' => $request->is_active,
                'deactived_at' => Carbon::now()->toDateTimeString(),
            ]);
            DB::commit();
            return redirect(route('adm.users'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.users'))->with('error', 'Failure Update !');  
        }
    }
}
