<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
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
            'title' => 'LOGIN | '. SiteSetting::first()->site_name
        ];

        return view('pages.auth.login-back', compact('head'));
    }

    public function authenticate(Request $request) {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $validator =  Validator::make($request->all(), [ 
            'email' => ['required'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator); 
        } else {

        $user = User::where('is_active', 1)->where('nik', $request->email)->orWhere('email', $request->email)->first();

            if($user ) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    
                    if(auth()->user()->role == 'user') {
                        return redirect()->route('user.absen');
                    } else {
                        return redirect()->route('adm.dashboard');
                    }
                }
                return back()->with('error', 'Login failed');
            } else {
                return back()->with('error', 'Account Not Found !');
            }
        }
    }

    public function logout() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
