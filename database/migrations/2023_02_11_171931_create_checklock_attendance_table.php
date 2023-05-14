<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklockAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklock_attendance', function (Blueprint $table) {
            $table->id();
            $table->enum('device', ['mobile', 'web'])->default('mobile');
            $table->enum('type', ['absen_biasa', 'absen_lembur', 'absen_luar_kota', 'absen_izin', 'undefine'])->default('absen_biasa');
            
            $table->unsignedBigInteger('shift_id')->nullable();;
            $table->unsignedBigInteger('employee_id');

            $table->date('date');
            
            $table->time('clock_in')->nullable()->default(null);
            $table->string('latlong_in')->nullable()->default(null);

            $table->time('clock_out')->nullable()->default(null);
            $table->string('latlong_out')->nullable()->default(null);
            
            $table->time('early_leave')->nullable()->default(null);
            $table->integer('late')->nullable()->default(null);
            $table->integer('overtime')->nullable()->default(null);
            $table->integer('total_work')->nullable()->default(null);
            $table->string('foto_masuk')->nullable()->default(null);
            $table->string('foto_keluar')->nullable()->default(null);
            $table->text('note')->nullable()->default(null);
            $table->text('note_in')->nullable()->default(null);
            $table->text('note_out')->nullable()->default(null);

            $table->boolean('is_auto_checkout_daily')->default(false);
            $table->boolean('is_attendace_daily_tolerance_limit')->default(false);
            $table->integer('time_tolerance_limit')->default(false);
            
            $table->boolean('is_active')->default(true);

            $table->unsignedBigInteger('id_jadwal_lembur')->nullable();
            
            $table->unsignedBigInteger('id_jenis_lembur')->nullable();
            
            $table->unsignedBigInteger('id_izin')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable()->default(null);
            $table->dateTime('updated_at')->nullable()->default(null);
            $table->dateTime('deleted_at')->nullable()->default(null);
            
            $table->foreign('id_jadwal_lembur')->references('id')->on('jadwal_lembur');
            $table->foreign('id_jenis_lembur')->references('id')->on('jenis_lembur');
            $table->foreign('id_izin')->references('id')->on('izin');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('employee_id')->references('id')->on('users');
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
        Schema::dropIfExists('checklock_attendance');
    }
}
