<?php

use App\Http\Controllers\AjuanPerizinanController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\EmailConfigurationController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisDiklatController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PengalamanKerjaController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TingkatPendidikanController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AjuanSuratController;
use Illuminate\Support\Facades\Route;
use Svg\Tag\Group;

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

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('isAdmin');
    Route::post('/user', [UserController::class, 'store'])->name('user.store')->middleware('isAdmin');
    Route::get('/user/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/user/change-password', [UserController::class, 'saveChangePassword'])->name('user.saveChangePassword');
    Route::get('/user/{id_users}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{id_users}/profile', [UserController::class, 'showAdmin'])->name('user.showAdmin')->middleware('isAdmin');
    Route::get('/user/{id_users}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('isAdmin');
    Route::put('/user/{id_users}', [UserController::class, 'update'])->name('user.update')->middleware('isAdmin');
    Route::delete('/user/{id_users}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('isAdmin');
    Route::post('/import', [UserController::class, 'import'])->name('import');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::get('/jabatan/create', [JabatanController::class, 'create'])->name('jabatan.create')->middleware('isAdmin');
    Route::post('/jabatan', [JabatanController::class, 'store'])->name('jabatan.store')->middleware('isAdmin');
    Route::get('/jabatan/{id_jabatan}', [JabatanController::class, 'show'])->name('jabatan.show')->middleware('isAdmin');
    Route::get('/jabatan/{id_jabatan}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit')->middleware('isAdmin');
    Route::put('/jabatan/{id_jabatan}', [JabatanController::class, 'update'])->name('jabatan.update')->middleware('isAdmin');
    Route::delete('/jabatan/{id_jabatan}', [JabatanController::class, 'destroy'])->name('jabatan.destroy')->middleware('isAdmin');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store')->middleware('isAdmin');
    Route::post('/kegiatan/timkegiatan', [KegiatanController::class, 'storeTimKegiatan'])->name('kegiatan.storeTimKegiatan')->middleware('isAdmin'); // URL berbeda untuk fungsi storeTimKegiatan
    Route::get('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');
    Route::get('/kegiatan/{id_kegiatan}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit')->middleware('isAdmin');
    Route::put('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update')->middleware('isAdmin');
    Route::delete('/kegiatan/{id_kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy')->middleware('isAdmin');

});
Route::post('/tingkatpendidikan', [TingkatPendidikanController::class, 'store'])->name('tingkatpendidikan.store')->middleware('isAdmin');
Route::get('/tingkatpendidikan', [TingkatPendidikanController::class, 'index'])->name('tingkatpendidikan.index');
Route::get('/tingkatpendidikan/{tingkatPendidikan}/edit', [TingkatPendidikanController::class, 'edit'])->name('tingkatpendidikan.edit');
Route::put('/tingkatpendidikan/{tingkatPendidikan}', [TingkatPendidikanController::class, 'update'])->name('tingkatpendidikan.update');
Route::delete('/tingkatpendidikan/{id_tingkat_pendidikan}', [TingkatPendidikanController::class, 'destroy'])->name('tingkatpendidikan.destroy');

// Route::resource('profile', ProfileController::class)->middleware('auth');
Route::get('/profile', [profileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::put('/profile/{id_profile}', [profileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/profile/pdf', [profileController::class, 'createPdf'])->name('profile.pdf')->middleware('auth');
Route::get('/profile/{id_users}/pdf', [profileController::class, 'createPdfAdmin'])->name('profile.pdfAdmin')->middleware('auth')->middleware('isAdmin');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/jenisdiklat', [JenisDiklatController::class, 'index'])->name('jenisdiklat.index');
    Route::post('/jenisdiklat', [JenisDiklatController::class, 'store'])->name('jenisdiklat.store')->middleware('isAdmin');
    Route::put('/jenisdiklat/{id_jenis_diklat}', [JenisDiklatController::class, 'update'])->name('jenisdiklat.update')->middleware('isAdmin');
    Route::delete('/jenisdiklat/{id_jenis_diklat}', [JenisDiklatController::class, 'destroy'])->name('jenisdiklat.destroy')->middleware('isAdmin');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/diklat', [DiklatController::class, 'index'])->name('diklat.index');
    Route::get('/diklat/{id_users}/profile', [DiklatController::class, 'showAdmin'])->name('diklat.showAdmin')->middleware('isAdmin');
    Route::post('/diklat', [DiklatController::class, 'store'])->name('diklat.store');
    Route::put('/diklat/{id_diklat}', [DiklatController::class, 'update'])->name('diklat.update')->middleware('isAdmin');
    Route::delete('/diklat/{id_diklat}', [DiklatController::class, 'destroy'])->name('diklat.destroy')->middleware('isAdmin');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/{id_users}/profile', [ArsipController::class, 'showAdmin'])->name('arsip.showAdmin')->middleware('isAdmin');
    Route::post('/arsip', [ArsipController::class, 'store'])->name('arsip.store');
    Route::put('/arsip/{id_arsip}', [ArsipController::class, 'update'])->name('arsip.update')->middleware('isAdmin');
    Route::delete('/arsip/{id_arsip}', [ArsipController::class, 'destroy'])->name('arsip.destroy')->middleware('isAdmin');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/generalsetting', [GeneralSettingController::class, 'index'])->name('generalsetting.index');
    Route::post('/generalsetting', [GeneralSettingController::class, 'store'])->name('generalsetting.store');
    Route::put('/generalsetting/{id_setting}', [GeneralSettingController::class, 'update'])->name('generalsetting.update')->middleware('isAdmin');
    Route::delete('/generalsettingsip/{id_setting}', [GeneralSettingController::class, 'destroy'])->name('generalsetting.destroy')->middleware('isAdmin');
});

// Route::get('/generalsetting', [GeneralSettingController::class, 'index'])->name('generalsetting.index')->middleware('auth');
// Route::put('/generalsetting/{id_profile}', [GeneralSettingController::class, 'update'])->name('generalsetting.update')->middleware('auth');

Route::resource('timkegiatan', \App\Http\Controllers\TimKegiatanController::class)->middleware('auth');

Route::resource('hubkel', \App\Http\Controllers\HubunganKeluargaController::class)->middleware('auth');

Route::get('keluarga/{id_users}/profile', [KeluargaController::class, 'showAdmin'])->name('keluarga.showAdmin')->middleware('isAdmin');
Route::resource('keluarga', \App\Http\Controllers\KeluargaController::class)->middleware('auth');

Route::get('penker/{id_users}/profile', [PengalamanKerjaController::class, 'showAdmin'])->name('penker.showAdmin')->middleware('isAdmin');
Route::resource('penker', \App\Http\Controllers\PengalamanKerjaController::class)->middleware('auth');

Route::get('pendidikan/{id_users}/profile', [PendidikanController::class, 'showAdmin'])->name('pendidikan.showAdmin')->middleware('isAdmin');
Route::resource('pendidikan', \App\Http\Controllers\PendidikanController::class)->middleware('auth');

Route::resource('peran', \App\Http\Controllers\PeranController::class)->middleware('auth');

Route::get('/laporan', [App\Http\Controllers\TimKegiatanController::class, 'laporan'])->name('laporan')->middleware('auth');

Route::resource('/kodesurat', \App\Http\Controllers\KodeSuratController::class)->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/filter', [PresensiController::class, 'filter'])->name('presensi.filter');
    Route::get('/presensi/filteruser', [App\Http\Controllers\PresensiController::class, 'filteruser'])->name('presensi.user');
    Route::post('/presensi/import', [PresensiController::class, 'import'])->name('presensi.import')->middleware('isAdmin');
    Route::get('presensi/admin', [PresensiController::class, 'filterAdmin'])->name('presensi.filterAdmin')->middleware('isAdmin');
    Route::get('/presensi/admin/export', [PresensiController::class, 'filterDataAdmin'])->name('presensi.filterDataAdmin')->middleware('isAdmin');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/ajuanperizinan', [AjuanPerizinanController::class, 'index'])->name('ajuanperizinan.index');
    Route::post('/ajuanperizinan', [AjuanPerizinanController::class, 'store'])->name('ajuanperizinan.store');
    Route::put('/ajuanperizinan/{id_perizinan}', [AjuanPerizinanController::class, 'update'])->name('ajuanperizinan.update');
    Route::delete('/ajuanperizinan/{id_perizinan}', [AjuanPerizinanController::class, 'destroy'])->name('ajuanperizinan.destroy');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/perizinan', [PerizinanController::class, 'indexStaff'])->name('perizinan.index');
    Route::post('/perizinan', [PerizinanController::class, 'pengajuan'])->name('perizinan.pengajuan');
    Route::put('/perizinan/{id_perizinan}', [PerizinanController::class, 'update'])->name('perizinan.update');
    Route::delete('/perizinan/{id_perizinan}', [PerizinanController::class, 'destroy'])->name('perizinan.destroy');
});

Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
Route::get('/cuti/{cuti}/edit', [CutiController::class, 'edit'])->name('cuti.edit');
Route::put('/cuti/update/{id}', [CutiController::class, 'update'])->name('cuti.update');
Route::delete('/cuti/{cuti}', [CutiController::class, 'destroy'])->name('cuti.destroy');
Route::get('/cuti/export', [CutiController::class, 'export'])->name('cuti.xlsx')->middleware('isAdmin');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
    Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
    Route::put('/lembur/update/{id_lembur}', [LemburController::class, 'update'])->name('lembur.update');
    Route::delete('/lembur/{id_lembur}', [LemburController::class, 'destroy'])->name('lembur.destroy');
    Route::get('/lembur/rekap', [LemburController::class, 'rekap'])->name('lembur.rekap');
    Route::get('/lembur/filter', [LemburController::class, 'filter'])->name('lembur.filter');
    Route::get('/lembur/export', [LemburController::class, 'export'])->name('lembur.xlsx')->middleware('isAdmin');
    Route::get('/ajuanlembur', [LemburController::class, 'atasan'])->name('lembur.atasan');
    Route::put('/ajuanlembur/update/{id_lembur}', [LemburController::class, 'status'])->name('lembur.status');
});

Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
Route::get('/notifikasi/fetch', [NotifikasiController::class, 'fetch'])->name('notifikasi.fetch');
Route::get('/notifikasi/{id_notifikasi}/detail', [NotifikasiController::class, 'detail'])->name('notifikasi.detail');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/url', [UrlController::class, 'index'])->name('url.index');
    Route::post('/url', [UrlController::class, 'store'])->name('url.store');
    Route::delete('/url/{id_url}', [UrlController::class, 'destroy'])->name('url.destroy');
    Route::put('/url/{id_url}', [UrlController::class, 'update'])->name('url.update');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');
    Route::post('/surat', [SuratController::class, 'store'])->name('surat.store');
    Route::put('/surat/update/{id_surat}', [SuratController::class, 'update'])->name('surat.update');
    Route::delete('/surat/{id_surat}', [SuratController::class, 'destroy'])->name('surat.destroy');

    Route::get('/ajuansurat', [AjuanSuratController::class, 'index'])->name('ajuansurat.index');
    Route::post('/ajuansurat', [AjuanSuratController::class, 'store'])->name('ajuansurat.store');
    Route::put('/ajuansurat/update/{id_ajuansurat}', [AjuanSuratController::class, 'update'])->name('ajuansurat.update');
    Route::delete('/ajuansurat/{id_ajuansurat}', [AjuanSuratController::class, 'destroy'])->name('ajuansurat.destroy');
});

Route::get('/email-configuration', [EmailConfigurationController::class, 'show'])->name('emailConfiguration.show');
Route::post('/email-configuration', [EmailConfigurationController::class, 'update'])->name('emailConfiguration.update');
Route::get('/s/{url_short}', [UrlController::class, 'redirect'])->name('url.redirect');