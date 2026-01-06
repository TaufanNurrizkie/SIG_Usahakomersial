<?php

use App\Http\Controllers\PetaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UsahaController as AdminUsahaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Camat\DashboardController as CamatDashboardController;
use App\Http\Controllers\Camat\UsahaController as CamatUsahaController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\UsahaController as UserUsahaController;
use App\Http\Controllers\Admin\KelurahanController as AdminKelurahanController;
use App\Http\Controllers\Admin\KategoriUsahaController as AdminKategoriUsahaController;
use App\Http\Controllers\Camat\KelurahanController as CamatKelurahanController;
use App\Http\Controllers\Camat\KategoriUsahaController as CamatKategoriUsahaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;

// ===========================================
// PUBLIC ROUTES
// ===========================================
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/peta', [PetaController::class, 'index'])->name('peta');

// ===========================================
// AUTH ROUTES (Breeze)
// ===========================================
require __DIR__.'/auth.php';

// ===========================================
// AUTHENTICATED ROUTES
// ===========================================
Route::middleware('auth')->group(function () {
    
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return redirect()->route($user->getDashboardRoute());
    })->name('dashboard');

    // ===========================================
    // ADMIN ROUTES
    // ===========================================
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Usaha management
        Route::get('/usaha', [AdminUsahaController::class, 'index'])->name('usaha.index');
        Route::get('/usaha/{usaha}', [AdminUsahaController::class, 'show'])->name('usaha.show');
        Route::post('/usaha/{usaha}/approve', [AdminUsahaController::class, 'approve'])->name('usaha.approve');
        Route::post('/usaha/{usaha}/reject', [AdminUsahaController::class, 'reject'])->name('usaha.reject');
        Route::delete('/usaha/{usaha}', [AdminUsahaController::class, 'destroy'])->name('usaha.destroy');
        
        // User management (admin only)
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', AdminUserController::class)->except(['show']);
        });

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

        // Master Data
        Route::resource('kelurahan', AdminKelurahanController::class);
        Route::resource('kategori', AdminKategoriUsahaController::class)->parameters(['kategori' => 'kategori']);
    });

    // ===========================================
    // CAMAT ROUTES
    // ===========================================
    Route::prefix('camat')->name('camat.')->middleware('role:camat')->group(function () {
        Route::get('/dashboard', [CamatDashboardController::class, 'index'])->name('dashboard');
        
        // Usaha approval
        Route::get('/usaha', [CamatUsahaController::class, 'index'])->name('usaha.index');
        Route::get('/usaha/riwayat', [CamatUsahaController::class, 'riwayat'])->name('usaha.riwayat');
        Route::get('/usaha/{usaha}', [CamatUsahaController::class, 'show'])->name('usaha.show');
        Route::post('/usaha/{usaha}/approve', [CamatUsahaController::class, 'approve'])->name('usaha.approve');
        Route::post('/usaha/{usaha}/reject', [CamatUsahaController::class, 'reject'])->name('usaha.reject');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

        // Master Data
        Route::resource('kelurahan', CamatKelurahanController::class);
        Route::resource('kategori', CamatKategoriUsahaController::class)->parameters(['kategori' => 'kategori']);
    });

    // ===========================================
    // USER ROUTES
    // ===========================================
    Route::prefix('user')->name('user.')->middleware('role:user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        
        // Usaha CRUD
        Route::resource('usaha', UserUsahaController::class);
        Route::delete('/usaha/{usaha}/dokumen/{dokumen}', [UserUsahaController::class, 'deleteDokumen'])
            ->name('usaha.dokumen.delete');
    });
});
