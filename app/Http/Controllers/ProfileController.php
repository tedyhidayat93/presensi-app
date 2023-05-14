<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\InOut;
use App\Models\Izin;
use App\Models\JenisIzin;
use App\Models\Shift;
use App\Models\SiteSetting;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{

    public function index()
    {

        $waktu = gmdate("H:i", time() + 7 * 3600);
        $t = explode(":", $waktu);
        $jam = $t[0];
        $menit = $t[1];
        $ucapan = "";
        if ($jam >= 00 and $jam < 10) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Pagi";
            }
        } else if ($jam >= 10 and $jam < 15) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Siang";
            }
        } else if ($jam >= 15 and $jam < 18) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Sore";
            }
        } else if ($jam >= 18 and $jam <= 24) {
            if ($menit > 00 and $menit < 60) {
                $ucapan = "Selamat Malam";
            }
        } else {
            $ucapan = "Error";
        }
        $head = [
            'title' => 'Profil Saya',
            'head_title_per_page' => "Profil Saya",
            'sub_title_per_page' => "",
            'breadcrumbs' => [
                [
                    'title' => 'Presensi',
                    'link' => route('user.absen'),
                    'is_active' => false,
                ],
                [
                    'title' => 'Profil Saya',
                    'link' => '#',
                    'is_active' => true,
                ]
            ]
        ];

        return view('pages.employee.profile', compact('head','ucapan'));
    }


    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [ 
            'password' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return redirect(route('user.profile'))->withInput()->withErrors($validator); 
        } else {
            DB::beginTransaction();        
            try {
                User::where('id', Auth::user()->id)->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => Carbon::now(),
                ]);
            
                DB::commit();
                return redirect(route('user.profile'))->with('success', 'Successfully change password.');  
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('user.profile'))->with('error', 'Failure !'.$e);  
            }
        }
    }

}
