<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\Cetak\PDFController;
use App\Http\Controllers\{
    SettingController,
    UserController,
    PolaController,
    BarangController,

};

use App\Models\Pegawai;


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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');

Route::middleware('loggedin')->group(function() {
    Route::get('login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'registerView'])->name('register-view');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    
});

Route::middleware('auth')->group(function() {
       
    
    Route::group(['middleware'=>['auth','role:admin,koordinator,su']],function(){

        //barang Manage
        Route::get('barang', [barangController::class, 'index'])->name('barang');
        Route::post('barangadd', [barangController::class, 'store'])->name('barangadd');
        Route::get('barangedit', [barangController::class, 'edit'])->name('barangedit');
        Route::POST('barangupdate', [barangController::class, 'update'])->name('barangupdate');
        Route::get('barangdelete/{id}', [barangController::class, 'destroy'])->name('barangdelete');

    
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

        

    });

    Route::group(['middleware'=>['auth','role:koordinator,su']],function(){
        

    
    });

    Route::group(['middleware'=>['auth','role:su']],function(){

        //Management User 
        Route::get('user', [UserController::class, 'index'])->name('user');
        Route::post('useradd', [UserController::class, 'store'])->name('useradd');
        Route::get('useredit', [UserController::class, 'edit'])->name('useredit');
        Route::post('userupdate', [UserController::class, 'update'])->name('userupdate');
        Route::get('userdelete/{id}', [UserController::class, 'destroy'])->name('userdelete');

        Route::POST('bonusall', [PenggajianController::class, 'bonusall'])->name('bonusall');

        Route::get('setting-perusahaan', [SettingController::class, 'index'])->name('setting-perusahaan');
        Route::get('setting-perusahaan/edit/{id}', [SettingController::class, 'edit'])->name('setting-edit');
        Route::post('setting-perusahaan/update/{id}', [SettingController::class, 'update'])->name('setting-update');
    });

        // Gocay Routing
    Route::get('/', [BarangController::class, 'index'])->name('barang');

    

});
