<?php

namespace App\Console;


use Carbon\Carbon;
use App\Helpers\General;
use App\Models\SiteSetting;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\AutoCheckoutAttendanceDailyCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $setting = SiteSetting::first();
        $cek_shift = General::cekShiftToday();
        $time = Carbon::createFromFormat('H:i', $cek_shift['jam_pulang'])
                ->addMinutes($setting->time_minute_auto_checkout_attendance_daily)
                ->format('H:i');


        // $schedule->command('inspire')->hourly();
        $schedule->command('attendance:autocheckout')->timezone($setting->timezone)->dailyAt($time);

        $schedule->command('artisan cache:clear')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
