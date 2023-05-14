<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Shift, ShiftsUsers, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Carbon\Carbon;

class ShiftController extends Controller
{

    // Shifts Setting
    public function settingShift ($id = null) {

        $head = [
            'title' => 'Setting Shift Waktu Pegawai',
            'head_title_per_page' => "Setting Shift Waktu Pegawai",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Shift',
                    'link' => route('adm.shift'),
                    'is_active' => true,
                ],
                [
                    'title' => 'Setting Shift Waktu Pegawai',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.store.shift");
            $edit = new Shift;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.update.shift");
            $edit = Shift::where('id', $id)->first();
        }
        $shift = Shift::where('id', $id)->where('is_active', 1)->first();
        $users = ShiftsUsers::where('shift_id',$shift->id)->get();

        
        $users_arr = ShiftsUsers::where('shift_id','=',$id)->pluck('user_id');
        
        if( count($users_arr) > 0) {
            // $users_shift = ShiftsUsers::join('users', 'users.id', 'shifts_users.user_id')
            // ->where('users.is_active', 1)
            // ->where('users.role', '=', 'user')
            // ->where('shifts_users.shift_id', '!=', $id)
            // ->whereNotIn('users.id', $users_arr)
            // ->get();
            $users_shift = User::leftJoin('shifts_users', 'users.id', 'shifts_users.user_id')
            ->where('users.is_active', 1)
            ->where('users.role', '=', 'user')
            // ->where('shifts_users.shift_id', '!=', $id)
            ->whereNotIn('users.id', $users_arr)
            ->get();
        } else {
            $users_shift = User::where('is_active', 1)->where('role', 'user')->orderBy('id', 'DESC')->get();
        }
        $route_delete = route('adm.delete.shift');
        return view('pages.admin.shift.employee_shift', compact('head','method','edit','shift','users','users_shift','button_value','route','route_delete'));
    }

    public function storeShiftUsers (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'user_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.setting.shift', $request->shift_id))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {


                foreach ($request->user_id as $r) {
                    $c = new ShiftsUsers();
                    $c->shift_id = $request->shift_id;
                    $c->user_id = $r ?? null;
                    $c->created_by = auth()->user()->id;
                    $c->save();
                }

                DB::commit();
                return redirect(route('adm.setting.shift',$request->shift_id))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.setting.shift',$request->shift_id))->with('error', 'Failure !');  
            }
        }
    }

    public function deleteShiftUser (Request $request) {
        try {
            ShiftsUsers::where('id', $request->id)->delete();
            DB::commit();
            return redirect(route('adm.setting.shift',$request->shift_id))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.setting.shift',$request->shift_id))->with('error', 'Failure Update !');  
        }
    }



    // Shifts
    public function indexShift ($id = null) {

        $head = [
            'title' => 'Shift Waktu',
            'head_title_per_page' => "Shift Waktu",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Shift',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.store.shift");
            $edit = new Shift;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.update.shift");
            $edit = Shift::where('id', $id)->first();
        }
        $data = Shift::orderBy('shift_name', 'ASC')->where('is_active', 1)->get();
        $route_delete = route('adm.delete.shift');
        return view('pages.admin.shift.index', compact('head','method','edit','data','button_value','route','route_delete'));
    }
    public function storeShift (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'shift_name'     => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.shift'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                Shift::create([
                    'shift_name' => $request->shift_name,
                    'senin_in' => $request->senin_in ?? null,
                    'senin_out' => $request->senin_out ?? null,
                    'selasa_in' => $request->selasa_in ?? null,
                    'selasa_out' => $request->selasa_out ?? null,
                    'rabu_in' => $request->rabu_in ?? null,
                    'rabu_out' => $request->rabu_out ?? null,
                    'kamis_in' => $request->kamis_in ?? null,
                    'kamis_out' => $request->kamis_out ?? null,
                    'jumat_in' => $request->jumat_in ?? null,
                    'jumat_out' => $request->jumat_out ?? null,
                    'sabtu_in' => $request->sabtu_in ?? null,
                    'sabtu_out' => $request->sabtu_out ?? null,
                    'minggu_in' => $request->minggu_in ?? null,
                    'minggu_out' => $request->minggu_out ?? null,
                    'is_active' => 1,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                return redirect(route('adm.shift'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.shift'))->with('error', 'Failure !');  
            }
        }
    }
    public function updateShift (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'shift_name' => 'required|string|min:2|max:250',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.shift'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                Shift::where('id', $request->id)->update([
                    'shift_name' => $request->shift_name,
                    'senin_in' => $request->senin_in,
                    'senin_out' => $request->senin_out,
                    'selasa_in' => $request->selasa_in,
                    'selasa_out' => $request->selasa_out,
                    'rabu_in' => $request->rabu_in,
                    'rabu_out' => $request->rabu_out,
                    'kamis_in' => $request->kamis_in,
                    'kamis_out' => $request->kamis_out,
                    'jumat_in' => $request->jumat_in,
                    'jumat_out' => $request->jumat_out,
                    'sabtu_in' => $request->sabtu_in,
                    'sabtu_out' => $request->sabtu_out,
                    'minggu_in' => $request->minggu_in,
                    'minggu_out' => $request->minggu_out,
                    // 'is_active' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
                return redirect(route('adm.shift'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.shift'))->with('error', 'Failure Update !');  
            }
        }
    }
    public function deleteShift (Request $request) {
        try {
            Shift::where('id', $request->id)->update([
                'is_active' => 0,
                'deleted_by' => auth()->user()->id,
                'deleted_at' => now(),
            ]);
            DB::commit();
            return redirect(route('adm.shift'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.shift'))->with('error', 'Failure Update !');  
        }
    }
}
