<?php
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\TimKegiatanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Kegiatan;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    $all_kegiatan = Kegiatan::all();
    $kegiatans = Kegiatan::where('tgl_mulai', '>', now())->orderBy('tgl_mulai', 'asc')->get();
    return view('home', [
        'kegiatans' => $kegiatans,
        'all_kegiatan' => $all_kegiatan,
    ]);
})->name('home')->middleware('auth');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('isAdmin');
    Route::post('/user', [UserController::class, 'store'])->name('user.store')->middleware('isAdmin');
    Route::get('/user/{id_users}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{id_users}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('isAdmin');
    Route::put('/user/{id_users}', [UserController::class, 'update'])->name('user.update')->middleware('isAdmin');
    Route::delete('/user/{id_users}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('isAdmin');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::get('/jabatan/create', [JabatanController::class, 'create'])->name('jabatan.create')->middleware('isAdmin');
    Route::post('/jabatan', [JabatanController::class, 'store'])->name('jabatan.store')->middleware('isAdmin');
    Route::get('/jabatan/{id_jabatan}', [JabatanController::class, 'show'])->name('jabatan.show')->middleware('isAdmin');
    Route::get('/jabatan/{id_jabatan}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit')->middleware('isAdmin');
    Route::put('/jabatan/{id_jabatan}', [JabatanController::class, 'update'])->name('jabatan.update')->middleware('isAdmin');
    Route::delete('/jabatan/{id_jabatan}', [JabatanController::class, 'destroy'])->name('jabatan.destroy')->middleware('isAdmin');
});


Route::group(['middleware' => ['auth']], function() {
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store')->middleware('isAdmin');
    Route::post('/kegiatan/timkegiatan', [KegiatanController::class, 'storeTimKegiatan'])->name('kegiatan.storeTimKegiatan')->middleware('isAdmin'); // URL berbeda untuk fungsi storeTimKegiatan
    Route::get('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show')->middleware('isAdmin');
    Route::get('/kegiatan/{id_kegiatan}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit')->middleware('isAdmin');
    Route::put('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update')->middleware('isAdmin');
    Route::delete('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy')->middleware('isAdmin');

});

// Route::resource('profile', ProfileController::class)->middleware('auth');
Route::get('/profile', [profileController::class, 'index'])->name('profile.index');
Route::put('/profile/{id_profile}', [profileController::class, 'update'])->name('profile.update');


Route::resource('timkegiatan', \App\Http\Controllers\TimKegiatanController::class)->middleware('auth');
Route::resource('hubkel', \App\Http\Controllers\HubunganKeluargaController::class)->middleware('auth');
Route::resource('keluarga', \App\Http\Controllers\KeluargaController::class)->middleware('auth');
Route::resource('arsip', \App\Http\Controllers\ArsipController::class)->middleware('auth');
Route::resource('penker', \App\Http\Controllers\PengalamanKerjaController::class)->middleware('auth');
