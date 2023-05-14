<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InOut;
use App\Models\Izin;
use App\Models\Location;
use App\Models\SiteSetting;
use App\Helpers\General;
use Carbon\Carbon;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function  __construct()
    {
        if(auth()->user() == null) {
            Auth::logout(); // Hapus session pengguna
            session()->invalidate();
            session()->regenerateToken();
    
            return redirect('/login')->withErrors([
                'expired' => 'Sesi Anda telah berakhir. Silakan login kembali.'
            ]);
        }
    }

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
            'title' => 'Dashboard ',
            'head_title_per_page' => "Dashboard",
            'sub_title_per_page' => "Hello, ". $ucapan ,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'link' => route('adm.dashboard'),
                    'is_active' => true,
                ]
            ]
        ];
        $total_employee = User::where(['role' => 'user', 'is_active' => 1])->count();
        $total_admin = User::where(['role' => 'admin', 'is_active' => 1])->count();
        $total_shift = Shift::where(['is_active' => 1])->count();
        $zona = Location::where(['is_active' => 1])->first();

        $absen_telat_today = InOut::where(['date' => Carbon::now()->toDateString(), 'type' => 'absen_biasa', 'is_active' => 1])->where('late','!=',null)->orderBy('created_at','DESC')->get();
        $izin_waiting = Izin::where('created_at', 'LIKE',  '%'. Carbon::now()->toDateString() .'%')->where(['is_active' => 1, 'is_approve' => 1])->orderBy('created_at','DESC')->get();

        // grafik datang terlambat
        $jan = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '01')->count();
        $feb = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '02')->count();
        $mar = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '03')->count();
        $apr = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '04')->count();
        $may = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '05')->count();
        $jun = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '06')->count();
        $jul = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '07')->count();
        $aug = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '08')->count();
        $sep = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '09')->count();
        $oct = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '10')->count();
        $nov = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '11')->count();
        $dec = InOut::where(['is_active' => 1])->where('late','!=',null)->whereYear('date', date('Y'))->whereMonth('date', '12')->count();

        $progres = $jan . ','. $feb . ','. $mar . ','. $apr . ','. $may . ','. $jun . ','. $jul . ','. $aug . ','. $sep . ','. $oct . ','. $nov . ','. $dec;
        $grafik_disiplin = [
            'progres' => $progres,
            'bulan' => "'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'",
        ];

        // grafik izin
        $jan2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '01')->count();
        $feb2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '02')->count();
        $mar2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '03')->count();
        $apr2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '04')->count();
        $may2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '05')->count();
        $jun2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '06')->count();
        $jul2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '07')->count();
        $aug2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '08')->count();
        $sep2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '09')->count();
        $oct2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '10')->count();
        $nov2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '11')->count();
        $dec2 = Izin::where(['is_active' => 1])->whereYear('created_at', date('Y'))->whereMonth('created_at', '12')->count();

        $progres2 = $jan2 . ','. $feb2 . ','. $mar2 . ','. $apr2 . ','. $may2 . ','. $jun2 . ','. $jul2 . ','. $aug2 . ','. $sep2 . ','. $oct2 . ','. $nov2 . ','. $dec2;
        $grafik_izin = [
            'progres' => $progres2,
            'bulan' => "'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'",
        ];

        // dd($grafik_disiplin);
        return view('pages.admin.dashboard', compact('head','zona', 'total_employee', 'total_admin', 'total_shift', 'absen_telat_today', 'izin_waiting', 'grafik_disiplin','grafik_izin'));
    }
}
