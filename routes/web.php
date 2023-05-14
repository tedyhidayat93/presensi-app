<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\IzinController;
use App\Http\Controllers\Admin\LemburController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\IzinController as UserIzinController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return redirect('/login');});
Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// *Role: Superadmin & Admin
Route::group(['prefix' => 'administrator', 'middleware' => ['role:superadmin|admin','auth']], function () {
    Route::get('/tes-admin', function () {return "ADMIN";});
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('adm.dashboard');
    
    // General Site Settings
    Route::group(['prefix' => 'site-setting'], function () {
        Route::get('', [SiteController::class, 'indexSite'])->name('adm.site');
        Route::put('/update', [SiteController::class, 'updateSite'])->name('adm.site.update');
    });

   
    // Employee
    Route::group(['prefix' => 'employee'], function () {
        Route::get('', [EmployeeController::class, 'indexEmployee'])->name('adm.employee');
        Route::get('/export', [EmployeeController::class, 'exportEmployee'])->name('adm.employee.export');
        Route::post('/import', [EmployeeController::class, 'importEmployee'])->name('adm.employee.import');
        Route::get('/create', [EmployeeController::class, 'createEmployee'])->name('adm.employee.create');
        Route::post('/store', [EmployeeController::class, 'storeEmployee'])->name('adm.employee.store');
        Route::get('/{id}/edit', [EmployeeController::class, 'editEmployee'])->name('adm.employee.edit');
        Route::put('/update', [EmployeeController::class, 'updateEmployee'])->name('adm.employee.update');
        Route::delete('/delete', [EmployeeController::class, 'deleteEmployee'])->name('adm.employee.delete');
    });
    
    // Penjadwalan Lembur
    Route::group(['prefix' => 'lembur'], function () {
        Route::get('', [LemburController::class, 'indexLembur'])->name('adm.lembur');
        Route::get('/export', [LemburController::class, 'exportLembur'])->name('adm.lembur.export');
        Route::post('/store', [LemburController::class, 'storeLembur'])->name('adm.lembur.update');
        Route::get('/{id}/edit', [LemburController::class, 'editLembur'])->name('adm.lembur.edit');
        Route::put('/update', [LemburController::class, 'updateLembur'])->name('adm.lembur.update.detail');
        Route::delete('/delete', [LemburController::class, 'deleteLembur'])->name('adm.lembur.delete');
        Route::get('/delete-personil/{id}', [LemburController::class, 'deletePersonil'])->name('adm.lembur.delete.personil');
    });
   
    // Izin
    Route::group(['prefix' => 'izin'], function () {
        Route::get('', [IzinController::class, 'indexIzin'])->name('adm.izin');
        Route::get('/export', [IzinController::class, 'exportIzin'])->name('adm.izin.export');
        Route::get('/detail/{id}', [IzinController::class, 'detail'])->name('adm.izin.detail');
        Route::get('/action/{id}', [IzinController::class, 'accIzin'])->name('adm.izin.acc');
    });

    // Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('', [UsersController::class, 'indexUser'])->name('adm.users');
        Route::get('/create', [UsersController::class, 'createUser'])->name('adm.users.create');
        Route::post('/store', [UsersController::class, 'storeUser'])->name('adm.users.store');
        Route::get('/{id}/edit', [UsersController::class, 'editUser'])->name('adm.users.edit');
        Route::put('/update', [UsersController::class, 'updateUser'])->name('adm.users.update');
        Route::delete('/delete', [UsersController::class, 'deleteUser'])->name('adm.users.delete');
    });
    
    
    // Shifts
    Route::group(['prefix' => 'shifts'], function () {
        Route::get('', [ShiftController::class, 'indexShift'])->name('adm.shift');
        Route::post('/store', [ShiftController::class, 'storeShift'])->name('adm.store.shift');
        Route::get('/{id}/edit', [ShiftController::class, 'indexShift'])->name('adm.edit.shift');
        Route::put('/update', [ShiftController::class, 'updateShift'])->name('adm.update.shift');
        Route::get('/{id}/setting', [ShiftController::class, 'settingShift'])->name('adm.setting.shift');
        Route::post('/store-users-shift', [ShiftController::class, 'storeShiftUsers'])->name('adm.store.shift.users');
        Route::delete('/delete', [ShiftController::class, 'deleteShift'])->name('adm.delete.shift');
        Route::delete('/delete-from-shift', [ShiftController::class, 'deleteShiftUser'])->name('adm.delete.shift.user');
    });
    
    // Absensi
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('', [AbsensiController::class, 'indexAttendance'])->name('adm.absen');
        Route::get('/detail/{id}', [AbsensiController::class, 'detail'])->name('adm.absen.detail');
        Route::put('/checkout-manual', [AbsensiController::class, 'checkoutManual'])->name('adm.absen.checkout.manual');
    });

    // Laporan
    Route::group(['prefix' => 'reporting'], function () {
        Route::get('', [ReportingController::class, 'index'])->name('adm.report');
        Route::get('/detail', [ReportingController::class, 'detailReportPerKaryawan'])->name('adm.report.detail');
        Route::get('/export', [ReportingController::class, 'export'])->name('adm.report.export');
        Route::get('/export-detail', [ReportingController::class, 'exportDetail'])->name('adm.report.export.detail');
    });
    
    // location
    Route::group(['prefix' => 'location'], function () {
        Route::get('', [LocationController::class, 'indexLocation'])->name('adm.location');
        Route::post('/store', [LocationController::class, 'storeLocation'])->name('adm.location.store');
        Route::get('/{id}/edit', [LocationController::class, 'indexLocation'])->name('adm.location.edit');
        Route::put('/update', [LocationController::class, 'updateLocation'])->name('adm.location.update');
        Route::post('/status', [LocationController::class, 'satusLocation'])->name('adm.location.status');
        Route::delete('/delete', [LocationController::class, 'deleteLocation'])->name('adm.location.delete');

    });
   
    // Master Data
    Route::group(['prefix' => 'master'], function () {
        
        // Employee Type
        Route::get('/employe-type', [MasterController::class, 'indexEmployeeType'])->name('adm.master.employee.type');
        Route::post('/employe-type/store', [MasterController::class, 'storeEmployeeType'])->name('adm.master.store.employee.type');
        Route::get('/employe-type/{id}/edit', [MasterController::class, 'indexEmployeeType'])->name('adm.master.edit.employee.type');
        Route::put('/employe-type/update', [MasterController::class, 'updateEmployeeType'])->name('adm.master.update.employee.type');
        Route::delete('/employe-type/delete', [MasterController::class, 'deleteEmployeeType'])->name('adm.master.delete.employee.type');
        
        // Jenis Izin
        Route::get('/not-present-type', [MasterController::class, 'indexJenisIzin'])->name('adm.master.jenis_izin');
        Route::post('/not-present-type/store', [MasterController::class, 'storeJenisIzin'])->name('adm.master.store.jenis_izin');
        Route::get('/not-present-type/{id}/edit', [MasterController::class, 'indexJenisIzin'])->name('adm.master.edit.jenis_izin');
        Route::put('/not-present-type/update', [MasterController::class, 'updateJenisIzin'])->name('adm.master.update.jenis_izin');
        Route::delete('/not-present-type/delete', [MasterController::class, 'deleteJenisIzin'])->name('adm.master.delete.jenis_izin');
        
        // Jenis Lembur
        Route::get('/ovetime-type', [MasterController::class, 'indexJenisLembur'])->name('adm.master.jenis_lembur');
        Route::post('/ovetime-type/store', [MasterController::class, 'storeJenisLembur'])->name('adm.master.store.jenis_lembur');
        Route::get('/ovetime-type/{id}/edit', [MasterController::class, 'indexJenisLembur'])->name('adm.master.edit.jenis_lembur');
        Route::put('/ovetime-type/update', [MasterController::class, 'updateJenisLembur'])->name('adm.master.update.jenis_lembur');
        Route::delete('/ovetime-type/delete', [MasterController::class, 'deleteJenisLembur'])->name('adm.master.delete.jenis_lembur');
        
        // Pendidikan
        Route::get('/education', [MasterController::class, 'indexEducation'])->name('adm.master.pendidikan');
        Route::post('/education/store', [MasterController::class, 'storeEducation'])->name('adm.master.store.pendidikan');
        Route::get('/education/{id}/edit', [MasterController::class, 'indexEducation'])->name('adm.master.edit.pendidikan');
        Route::put('/education/update', [MasterController::class, 'updateEducation'])->name('adm.master.update.pendidikan');
        Route::delete('/education/delete', [MasterController::class, 'deleteEducation'])->name('adm.master.delete.pendidikan');

    });
});

// *Role: User
Route::group(['prefix' => 'employee', 'middleware' => ['role:user','auth']], function () {
    Route::get('/tes-user', function () {return "ADMIN";});
    
    // PROFILE
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/update-password', [ProfileController::class, 'changePassword'])->name('user.profile.update_password');

    // ABSENSI
    Route::group(['prefix' => 'absen'], function () {
        Route::get('', [AbsenController::class, 'index'])->name('user.absen');
        Route::post('/attendance', [AbsenController::class, 'checkInOut'])->name('user.absen.io');
        Route::get('/detail/{id}', [AbsenController::class, 'detail'])->name('user.absen.detail');

    });

    // IZIN
    Route::group(['prefix' => 'izin'], function () {
        Route::get('', [UserIzinController::class, 'index'])->name('user.izin');
        Route::post('/send', [UserIzinController::class, 'send'])->name('user.izin.send');
        Route::get('/detail/{id}', [UserIzinController::class, 'detail'])->name('user.izin.detail');

    });
});
