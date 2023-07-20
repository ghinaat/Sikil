<?php
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KegiatanController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

// Route::resource('jabatan', \App\Http\Controllers\JabatanController::class);
Route::resource('user', \App\Http\Controllers\UserController::class);

Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
Route::get('/jabatan/create', [JabatanController::class, 'create'])->name('jabatan.create');
Route::post('/jabatan', [JabatanController::class, 'store'])->name('jabatan.store');
Route::get('/jabatan/{id_jabatan}', [JabatanController::class, 'show'])->name('jabatan.show');
Route::get('/jabatan/{id_jabatan}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
Route::put('/jabatan/{id_jabatan}', [JabatanController::class, 'update'])->name('jabatan.update');
Route::delete('/jabatan/{id_jabatan}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');


Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
Route::get('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');
Route::get('/kegiatan/{id_kegiatan}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
Route::put('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
Route::delete('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');