<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\SpmbController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\StatistikController as AdminStatistikController;
use App\Http\Controllers\Admin\AlumniController as AdminAlumniController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\FasilitasController as AdminFasilitasController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\EkstrakurikulerController as AdminEkstrakurikulerController;
use App\Http\Controllers\Admin\SpmbController as AdminSpmbController;

/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// STATISTIK PUBLIC
Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');

// BERITA PUBLIC
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/search', [BeritaController::class, 'search'])->name('search');
    Route::get('/recent', [BeritaController::class, 'recent'])->name('recent');
    Route::get('/author/{author}', [BeritaController::class, 'byAuthor'])->name('by-author');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('show');
    Route::get('/{id}/detail', [BeritaController::class, 'detail'])->name('detail');
});

// EKSTRAKURIKULER PUBLIC
Route::prefix('ekstrakurikuler')->name('ekstrakurikuler.')->group(function () {
    // Halaman utama daftar eskul (PlayStation Style)
    Route::get('/', [EkstrakurikulerController::class, 'index'])->name('index');
    
    // Search & Popular (AJAX)
    Route::get('/search', [EkstrakurikulerController::class, 'search'])->name('search');
    Route::get('/popular', [EkstrakurikulerController::class, 'popular'])->name('popular');
    
    // Filter by pembina
    Route::get('/pembina/{pembina}', [EkstrakurikulerController::class, 'byPembina'])->name('by-pembina');
    
    // Detail Eskul (harus di paling bawah karena wildcard)
    Route::get('/{slug}', [EkstrakurikulerController::class, 'show'])->name('show');
});

// PEGAWAI PUBLIC
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');

// ALUMNI PUBLIC
Route::prefix('alumni')->name('alumni.')->group(function () {
    Route::get('/', [AlumniController::class, 'index'])->name('index');
    Route::get('/daftar', [AlumniController::class, 'create'])->name('create');
    Route::post('/daftar', [AlumniController::class, 'store'])->name('store');
    Route::get('/map-data', [AlumniController::class, 'mapData'])->name('map-data');
});

// FASILITAS PUBLIC
Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

// GALERI PUBLIC
Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/{slug}', [GaleriController::class, 'show'])->name('show');
});

// PUBLIC SPMB
Route::prefix('spmb')->name('spmb.')->group(function () {
    Route::get('/', [SpmbController::class, 'index'])->name('index');
    Route::get('/{slug}', [SpmbController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.process');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ========== BERITA ==========
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [AdminBeritaController::class, 'index'])->name('index');
            Route::get('/create', [AdminBeritaController::class, 'create'])->name('create');
            Route::post('/', [AdminBeritaController::class, 'store'])->name('store');
            Route::get('/{berita}/edit', [AdminBeritaController::class, 'edit'])->name('edit');
            Route::put('/{berita}', [AdminBeritaController::class, 'update'])->name('update');
            Route::delete('/{berita}', [AdminBeritaController::class, 'destroy'])->name('destroy');
            Route::get('/{berita}', [AdminBeritaController::class, 'show'])->name('show');
            Route::post('/auto-save', [AdminBeritaController::class, 'autoSave'])->name('auto-save');
            Route::delete('/{berita}/image', [AdminBeritaController::class, 'deleteImage'])->name('delete-image');
            Route::post('/{berita}/image', [AdminBeritaController::class, 'uploadImage'])->name('upload-image');
        });

        // ========== EKSTRAKURIKULER ==========
        Route::resource('ekstrakurikuler', AdminEkstrakurikulerController::class);

        // ========== PEGAWAI ==========
        Route::prefix('pegawai')->name('pegawai.')->group(function () {
            Route::get('/', [AdminPegawaiController::class, 'index'])->name('index');
            Route::get('/create', [AdminPegawaiController::class, 'create'])->name('create');
            Route::post('/', [AdminPegawaiController::class, 'store'])->name('store');
            Route::get('/export-pdf', [AdminPegawaiController::class, 'exportPDF'])->name('export-pdf');
            Route::get('/{pegawai}/edit', [AdminPegawaiController::class, 'edit'])->name('edit');
            Route::put('/{pegawai}', [AdminPegawaiController::class, 'update'])->name('update');
            Route::delete('/{pegawai}', [AdminPegawaiController::class, 'destroy'])->name('destroy');
        });

        // ========== STATISTIK ==========
        Route::prefix('statistik')->name('statistik.')->group(function () {
            Route::get('/', [AdminStatistikController::class, 'index'])->name('index');
            Route::post('/update', [AdminStatistikController::class, 'updateStatistik'])->name('update');
            
            Route::post('/mutasi', [AdminStatistikController::class, 'storeMutasi'])->name('mutasi.store');
            Route::delete('/mutasi/{id}', [AdminStatistikController::class, 'destroyMutasi'])->name('mutasi.destroy');
            
            Route::get('/rekap-tahunan', [AdminStatistikController::class, 'rekapTahunan'])->name('rekap-tahunan');
            Route::post('/rekap-tahunan/generate', [AdminStatistikController::class, 'generateRekapTahunan'])->name('rekap-tahunan.generate');
            Route::delete('/rekap-tahunan/{id}', [AdminStatistikController::class, 'destroyRekapTahunan'])->name('rekap-tahunan.destroy');
            Route::get('/rekap-tahunan/{id}/export', [AdminStatistikController::class, 'exportRekapTahunan'])->name('rekap-tahunan.export');

            Route::get('/rekap-bulanan', [AdminStatistikController::class, 'rekapBulanan'])->name('rekap-bulanan');
            Route::post('/rekap-bulanan/generate', [AdminStatistikController::class, 'generateRekapBulanan'])->name('rekap-bulanan.generate');
            Route::post('/rekap-bulanan/generate-all', [AdminStatistikController::class, 'generateAllRekapBulanan'])->name('rekap-bulanan.generate-all');
            Route::delete('/rekap-bulanan/{id}', [AdminStatistikController::class, 'destroyRekapBulanan'])->name('rekap-bulanan.destroy');
        });

        // ========== ALUMNI ==========
        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('/', [AdminAlumniController::class, 'index'])->name('index');
            Route::get('/create', [AdminAlumniController::class, 'create'])->name('create');
            Route::post('/', [AdminAlumniController::class, 'store'])->name('store');
            Route::get('/export-pdf', [AdminAlumniController::class, 'exportPDF'])->name('export-pdf');
            Route::get('/check-duplicates', [AdminAlumniController::class, 'checkDuplicateNoHP'])->name('check-duplicates');
            Route::post('/delete-duplicates', [AdminAlumniController::class, 'deleteDuplicates'])->name('delete-duplicates');
            Route::get('/{alumni}/edit', [AdminAlumniController::class, 'edit'])->name('edit');
            Route::put('/{alumni}', [AdminAlumniController::class, 'update'])->name('update');
            Route::post('/{alumni}/approve', [AdminAlumniController::class, 'approve'])->name('approve');
            Route::post('/{alumni}/reject', [AdminAlumniController::class, 'reject'])->name('reject');
            Route::post('/{alumni}/toggle-featured', [AdminAlumniController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::delete('/{alumni}', [AdminAlumniController::class, 'destroy'])->name('destroy');
            
            Route::get('/universitas', [AdminAlumniController::class, 'universitasIndex'])->name('universitas');
            Route::post('/universitas', [AdminAlumniController::class, 'universitasStore'])->name('universitas.store');
            Route::put('/universitas/{universitas}', [AdminAlumniController::class, 'universitasUpdate'])->name('universitas.update');
            Route::delete('/universitas/{universitas}', [AdminAlumniController::class, 'universitasDestroy'])->name('universitas.destroy');
        });

        // ========== FASILITAS ==========
        Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
            Route::get('/', [AdminFasilitasController::class, 'index'])->name('index');
            Route::get('/create', [AdminFasilitasController::class, 'create'])->name('create');
            Route::post('/', [AdminFasilitasController::class, 'store'])->name('store');
            Route::get('/{fasilitas}/edit', [AdminFasilitasController::class, 'edit'])->name('edit');
            Route::put('/{fasilitas}', [AdminFasilitasController::class, 'update'])->name('update');
            Route::delete('/{fasilitas}', [AdminFasilitasController::class, 'destroy'])->name('destroy');
        });

        // ========== GALERI ==========
        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [AdminGaleriController::class, 'index'])->name('index');
            Route::get('/create', [AdminGaleriController::class, 'create'])->name('create');
            Route::post('/', [AdminGaleriController::class, 'store'])->name('store');
            Route::get('/{galeri}/edit', [AdminGaleriController::class, 'edit'])->name('edit');
            Route::put('/{galeri}', [AdminGaleriController::class, 'update'])->name('update');
            Route::delete('/{galeri}', [AdminGaleriController::class, 'destroy'])->name('destroy');
            Route::post('/{galeri}/delete-image', [AdminGaleriController::class, 'deleteImage'])->name('delete-image');
            Route::post('/{galeri}/toggle-featured', [AdminGaleriController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/{galeri}/toggle-active', [AdminGaleriController::class, 'toggleActive'])->name('toggle-active');
        });

        // ========== SPMB ==========
        Route::prefix('spmb')->name('spmb.')->group(function () {
            Route::get('/', [AdminSpmbController::class, 'index'])->name('index');
            Route::get('/create', [AdminSpmbController::class, 'create'])->name('create');
            Route::post('/', [AdminSpmbController::class, 'store'])->name('store');
            Route::get('/{spmb}/edit', [AdminSpmbController::class, 'edit'])->name('edit');
            Route::put('/{spmb}', [AdminSpmbController::class, 'update'])->name('update');
            Route::delete('/{spmb}', [AdminSpmbController::class, 'destroy'])->name('destroy');
            Route::post('/{spmb}/delete-image', [AdminSpmbController::class, 'deleteImage'])->name('delete-image');
            Route::post('/{spmb}/delete-video', [AdminSpmbController::class, 'deleteVideo'])->name('delete-video');
            Route::post('/{spmb}/reorder-images', [AdminSpmbController::class, 'reorderImages'])->name('reorder-images');
        });

        // ========== LOGOUT ==========
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404');
});