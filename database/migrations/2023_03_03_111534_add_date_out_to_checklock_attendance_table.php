<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateOutToChecklockAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checklock_attendance', function (Blueprint $table) {
            $table->date('date_out')->nullable()->default(null)->after('latlong_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checklock_attendance', function (Blueprint $table) {
            $table->dropColumn('date_out');
        });
    }
}
