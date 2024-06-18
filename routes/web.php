<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransTagihanController;
use App\Http\Controllers\TransTagihanSiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::redirect('/', '/dashboard-general-dashboard');

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::resource('/students', StudentController::class)->names([
    'index'   => 'students.index',
    'create'  => 'students.create',
    'store'   => 'students.store',
    'show'    => 'students.show',
    'edit'    => 'students.edit',
    'update'  => 'students.update',
    'destroy' => 'students.destroy',
]);
Route::get('/page-student', [StudentController::class, 'page'])->name('pageStudent');
Route::post('/post-student', [StudentController::class, 'saveOrUpdate'])->name('saveOrUpdate');

Route::resource('/spp',TransTagihanController::class)->names([
    'index'   => 'spp.index',
    'create'  => 'spp.create',
    'store'   => 'spp.store',
    'show'    => 'spp.show',
    'edit'    => 'spp.edit',
    'update'  => 'spp.update',
    'destroy' => 'spp.destroy',
]);

Route::get('/page-spp', [TransTagihanController::class, 'page'])->name('pageSpp');
Route::get('/page-spp-detail', [TransTagihanController::class, 'pageDetail'])->name('pageSppDetail');
Route::post('/payment', [TransTagihanController::class, 'payment'])->name('payment');
Route::get('/kwitansi/{id}', [TransTagihanController::class, 'kwitansi'])->name('kwitansi');

Route::resource('/sppStudent',TransTagihanSiswaController::class)->names([
    'index'   => 'sppStudent.index',
    'create'  => 'sppStudent.create',
    'store'   => 'sppStudent.store',
    'show'    => 'sppStudent.show',
    'edit'    => 'sppStudent.edit',
    'update'  => 'sppStudent.update',
    'destroy' => 'sppStudent.destroy',
]);

Route::get('/page-sppStudent', [TransTagihanSiswaController::class, 'page'])->name('pageSppStudent');
Route::post('/paymentStudent', [TransTagihanSiswaController::class, 'payment'])->name('paymentStudent');
Route::get('/kwitansiStudent/{id}', [TransTagihanSiswaController::class, 'kwitansi'])->name('kwitansiStudent');

Route::get('/laporan', [laporanController::class, 'index'])->name('index');
Route::get('/page-laporan-lunas', [laporanController::class, 'pageLunas'])->name('pageLaporanLunas');
Route::get('/page-laporan-belumLunas', [laporanController::class, 'pageBelumLunas'])->name('pageLaporanBelumLunas');
Route::get('/cetak-laporan/{id}', [laporanController::class, 'cetakPdf'])->name('cetakPdf');

Route::middleware(['auth'])->group(function(){
    Route::get('home', [DashboardController::class, 'index'])->name('home');
});

Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::post('/ubahPassword', [DashboardController::class, 'ubahPassword'])->name('ubahPassword');


