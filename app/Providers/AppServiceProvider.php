<?php

namespace App\Providers;


use App\Models\Izin;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        $general_site = SiteSetting::first();
        $izin = Izin::where('is_approve', 1)->where('is_active', 1)->count();
        Carbon::setLocale($general_site->timezone);

        date_default_timezone_set($general_site->timezone);
        View::share([
            'site' => $general_site,
            'version' => '0.0.1',
            'total_izin_waiting' => $izin,
            'date_now' => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'tagline_app' => 'Aplikasi Presensi Kehadiran Karyawan',
        ]);
    }
}
