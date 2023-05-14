<?php

namespace App\Console\Commands;

use App\Models\SiteSetting;
use App\Models\InOut;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AutoCheckoutAttendanceDailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:autocheckout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto checkout for employees attendance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $setting = SiteSetting::first();
        
        if($setting->is_auto_checkout_attendance_daily == 1) {
            $last_IO = InOut::where([
                'type' => 'absen_biasa',
                'date' => Carbon::now()->format('Y-m-d'),
                'is_active' => 1,
            ])
            ->whereNull('clock_out')
            ->get();

            foreach($last_IO as $r) {
                // hitung total jam kerja
                $jam_masuk = Carbon::createFromFormat('Y-m-d H:i:s', $r->date . ' ' . $r->clock_in);
                $jam_pulang = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $totalWork = $jam_masuk->diffInSeconds($jam_pulang);
    
                InOut::where('id', $r->id)->update([
                    'clock_out' => Carbon::now()->format('H:i:s'),
                    'latlong_out' => null,
                    'note_out' => 'Auto checkout by system.',
                    'foto_keluar' => null,
                    'total_work' => $totalWork ?? null,
                    'is_auto_checkout_daily' => 1,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

        } else {
            return false;
        }

    }
}
