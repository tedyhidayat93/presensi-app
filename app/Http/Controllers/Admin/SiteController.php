<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\General;
use Illuminate\Support\Facades\Storage;
use App\Models\{SiteSetting, Timezone};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Image;
use Intervention\Image\ImageManagerStatic as Image;

class SiteController extends Controller
{

    // site
    public function indexSite ($id = null) {
        $head = [
            'title' => 'Pengaturan ',
            'head_title_per_page' => "Pengaturan",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
            [
            'title' => 'Dashboard',
            'link' => route('adm.dashboard'),
            'is_active' => false,
            ],
            [
            'title' => 'Pengaturan',
            'link' => '#',
            'is_active' => true,
            ],
          ]
        ];
        
        $edit = SiteSetting::where('status', 1)->first();
        $timezones = Timezone::where('is_active', 1)->get();
        $route_update = route('adm.site.update');
        $button_value = 'Update';
        return view('pages.admin.settings.site.index', compact('head','timezones','edit','route_update','button_value'));
    }
    public function updateSite (Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [ 
            'site_name' => 'min:2',
            'copyright_footer' => 'min:2',
            'logo' => 'mimes:jpg,jpeg,png,gif|max:2048', //2 MB
            'favico' => 'mimes:ico,jpg,jpeg,png,gif|max:2048', //2 MB
        ]);

        if ($validator->fails()) {
            $tab_active = $request->tab_val;
            if($tab_active == 'general') {
                session()->put('tab_active', 'general');
            } else if($tab_active == 'zonasi') {
                session()->put('tab_active', 'zonasi');
            }

            return redirect()->back()->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {

                $tab_active = $request->tab_val;
                if($tab_active == 'general') {
                    session()->put('tab_active', 'general');
                } else if($tab_active == 'zonasi') {
                    session()->put('tab_active', 'zonasi');
                }
               
                $tab_active = $request->tab_val;
                if($tab_active == 'general') {
                    session()->put('tab_active', 'general');
                    if($request->hasFile('logo')) {
                        $logo =  $this->uploadFile('image', $request->file('logo'));
                    }
                    
                    if($request->hasFile('favico')) {
                        $favico =  $this->uploadFile('image', $request->file('favico'));
                    }
                    $data = [
                        'site_name' => $request->site_name,
                        'favico' => $favico ?? $request->old_favico,
                        'logo' => $logo ?? $request->old_logo,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'copyright_footer' => $request->copyright_footer,
                    ];
                } else if($tab_active == 'zonasi') {
                    $data = [
                        'is_using_radius' => $request->is_using_radius ?? 1,
                        'timezone' => $request->timezone,
                        'is_attendace_daily_tolerance_limit' => $request->is_tolerance,
                        'time_minute_attendance_tolerance_limit_daily' => $request->time_tolerance,
                        'is_auto_checkout_attendance_daily' => $request->is_auto_checkout_harian,
                        'time_minute_auto_checkout_attendance_daily' => $request->time_auto_checkout,
                        ];
                }

                $client = SiteSetting::where('id', $request->id)->update($data);

                DB::commit();
                return redirect()->back()->with('success', 'Successfully updating data.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Failure Update !'. $e);  
            }
        }
    }
    public function uploadFile($type = null, $file = null) {
        
        if($type == 'image') {
            $path = public_path('uploads/images/site');
        } else if($type == 'document') {
            $path = public_path('uploads/documents/site');
        }
        if (!File::exists($path)) File::makeDirectory($path, 0775, true, true, true);

        $name = time() . '-' . $file->getClientOriginalName();
        $file->move($path, $name);

        return $name;
    }
}
