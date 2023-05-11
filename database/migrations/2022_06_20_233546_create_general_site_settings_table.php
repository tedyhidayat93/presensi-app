<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('favico')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->boolean('is_using_radius')->default(true);
            $table->integer('radius')->nullable();
            $table->string('lat_loc')->nullable();
            $table->string('long_loc')->nullable();
            $table->string('copyright_footer')->nullable();
            $table->string('timezone')->default('Asia/Jakarta');
            $table->time('start_overtime')->nullable();
            
            $table->boolean('is_auto_checkout_attendance_daily')->default(false);
            $table->integer('time_minute_auto_checkout_attendance_daily')->default(null)->nullable();

            $table->boolean('is_attendace_daily_tolerance_limit')->default(false);
            $table->integer('time_minute_attendance_tolerance_limit_daily')->default(null)->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable()->default(null);
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('status')->default(true);

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_site_settings');
    }
}