<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name');
            
            $table->time('senin_in')->nullable();
            $table->time('senin_out')->nullable();
            $table->time('selasa_in')->nullable();
            $table->time('selasa_out')->nullable();
            $table->time('rabu_in')->nullable();
            $table->time('rabu_out')->nullable();
            $table->time('kamis_in')->nullable();
            $table->time('kamis_out')->nullable();
            $table->time('jumat_in')->nullable();
            $table->time('jumat_out')->nullable();
            $table->time('sabtu_in')->nullable();
            $table->time('sabtu_out')->nullable();
            $table->time('minggu_in')->nullable();
            $table->time('minggu_out')->nullable();
;
            
            $table->boolean('is_active')->default(true);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable()->default(null);
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

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
        Schema::dropIfExists('shifts');
    }
}
