<?php

use App\Http\Livewire\Backend\BarangKeluar;
use App\Http\Livewire\Backend\BarangMasuk;
use App\Http\Livewire\Backend\Dashboard;
use App\Http\Livewire\Backend\Inventaris;
use App\Http\Livewire\Backend\JenisBarang;
use App\Http\Livewire\Backend\Laporan;
use App\Http\Livewire\Backend\NamaBarang;
use App\Http\Livewire\Backend\Profil;
use App\Http\Livewire\Backend\User;
use App\Http\Livewire\Login;
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

// Route::get('/', function () {
//     return view('login');
// });
Route::get('/', Login::class)->name('login');

route::group(['middleware' => ['auth', 'IsRole:1']], function () {
    // Route::get('/dashboard/pegawai', Pegawai::class)->name('pegawai');
    Route::get('/dashboard/user', User::class)->name('user');
    Route::get('/dashboard/laporan', Laporan::class)->name('Laporan');
});
route::group(['middleware' => ['auth', 'IsRole:2']], function () {
    Route::get('/dashboard/jenbar', JenisBarang::class)->name('jenbar');
    Route::get('/dashboard/nambar', NamaBarang::class)->name('nambar');
    Route::get('/dashboard/inventaris', Inventaris::class)->name('inventaris');
    Route::get('/dashboard/barang-masuk', BarangMasuk::class)->name('BarangMasuk');
    Route::get('/dashboard/barang-keluar', BarangKeluar::class)->name('BarangKeluar');
});
route::group(['middleware' => ['auth', 'IsRole:1,2']], function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/dashboard/profil', Profil::class)->name('profil');
    Route::get('/dashboard/laporan', Laporan::class)->name('Laporan');
});