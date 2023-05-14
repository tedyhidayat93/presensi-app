<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['superadmin', 'admin','user'])->nullable()->default('user');
            $table->string('full_name');
            $table->enum('type', ['staff', 'non_staff','NA'])->nullable()->default(null);
            $table->enum('status', ['kontrak', 'tetap','magang','harian','freelance'])->nullable()->default(null);
            $table->unsignedBigInteger('employee_type')->nullable();
            $table->string('username')->unique();
            $table->string('nik')->unique()->nullable()->default(null);
            $table->string('nip')->unique()->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->longText('address')->nullable();
            $table->enum('gender', ['L', 'P','NA'])->nullable();
            $table->enum('religion', ['islam', 'kristen','khongucu','hindu','budha','another'])->nullable();
            $table->string('photo_profile')->nullable();
            $table->unsignedBigInteger('shift')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_overtime')->default(false);
            
            $table->unsignedBigInteger('last_education')->nullable();
            
            $table->date('tanggal_masuk')->default(null)->nullable();
            $table->date('tanggal_keluar')->default(null)->nullable();

            $table->dateTime('registered_at')->nullable()->default(null);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('actived_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deactived_at')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('last_location')->nullable();

            $table->boolean('is_web')->default(false);
            $table->boolean('is_mobile')->default(true);
            $table->rememberToken();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // $table->foreign('employee_type')->references('id')->on('employee_types');
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
        Schema::dropIfExists('users');
    }
}
