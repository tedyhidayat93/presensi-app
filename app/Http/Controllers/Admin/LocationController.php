<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Location};
use FontLib\Table\Type\loca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LocationController extends Controller
{

    // Location
    public function indexLocation ($id = null) {

        $head = [
            'title' => 'Zona & Lokasi ',
            'head_title_per_page' => "Zona Lokasi",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Zona Lokasi',
                    'link' => '#',
                    'is_active' => true,
                ],
            ]
        ];

        if($id == null) {
            $button_value = 'Simpan';
            $method = '';
            $route = route("adm.location.store");
            $edit = new Location;
        } else {
            $button_value = 'Edit';
            $method = null;
            $route = route("adm.location.update");
            $edit = Location::where('id', $id)->first();
        }
        $data = Location::orderBy('id', 'DESC')->get();
        $route_delete = route('adm.location.delete');
        return view('pages.admin.master.location.index', compact('head','method','edit','data','button_value','route','route_delete'));
    }
    public function storeLocation (Request $request) {
        // dd($request->type);
        $validator = Validator::make($request->all(), [ 
            'name'     => 'required|string|min:2|max:250',
            'lat_loc'     => 'required',
            'long_loc'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.location'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                Location::create([
                    'name' => $request->name,
                    'lat_loc' => $request->lat_loc,
                    'long_loc' => $request->long_loc,
                    'radius' => $request->radius,
                    'is_active' => 0,
                    'created_by' => auth()->user()->id,
                ]);
                DB::commit();
                return redirect(route('adm.location'))->with('success', 'Successfully added new data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.location'))->with('error', 'Failure !');  
            }
        }
    }
    public function updateLocation (Request $request) {
        $validator = Validator::make($request->all(), [ 
            'name'     => 'required|string|min:2|max:250',
            'lat_loc'     => 'required',
            'long_loc'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('adm.location'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                Location::where('id', $request->id)->update([
                    'name' => $request->name,
                    'lat_loc' => $request->lat_loc,
                    'long_loc' => $request->long_loc,
                    'radius' => $request->radius,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                DB::commit();
                return redirect(route('adm.location'))->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('adm.location'))->with('error', 'Failure Update !');  
            }
        }
    }
    public function satusLocation (Request $request) {
        try {
            
            $loc_count = Location::count();
            if($loc_count > 1) {
                Location::where('is_active', 1)->update([
                    'is_active' => 0,
                ]);
                Location::where('id', $request->id)->update([
                    'is_active' => 1,
                ]);
            } else {
                if($request->is_active == 1) {
                    $data = ['is_active' => 0];
                } else {
                    $data = ['is_active' => 1];
                }
                Location::where('id', $request->id)->where('is_active', $request->is_active)->update($data);
            }
            DB::commit();
            return redirect(route('adm.location'))->with('success', 'Successfully Activation.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.location'))->with('error', 'Failure Update !');  
        }
    }
    public function deleteLocation (Request $request) {
        try {
            Location::where('id', $request->id)->delete();
            DB::commit();
            return redirect(route('adm.location'))->with('success', 'Successfully deleting data.');  
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adm.location'))->with('error', 'Failure Update !');  
        }
    }



}
