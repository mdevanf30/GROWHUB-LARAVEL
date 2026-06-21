<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterAkun;
use App\Http\Controllers\Login;
use App\Http\Controllers\FreelancerDashboard;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UmkmProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UMKMDashboardController;
use App\Http\Controllers\BuatProyekController;
use App\Http\Controllers\DetailProyekController;
use App\Http\Controllers\ProjectApplicantController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\ProjectCancellationController; // <-- FIX 1: SUDAH DI-IMPORT DI SINI!
use App\Http\Controllers\ProjectProgressController;

Route::get('/home', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.index');
        }

        $activeRole = session()->get('active_role', 'Freelancer');
        return $activeRole === 'UMKM' 
            ? redirect()->route('umkm.dashboard') 
            : redirect()->route('dashboard_freelance');
    }
    return view('home');
})->name('home');

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.index');
        }

        $activeRole = session()->get('active_role', 'Freelancer');
        return $activeRole === 'UMKM' 
            ? redirect()->route('umkm.dashboard') 
            : redirect()->route('dashboard_freelance');
    }
    return redirect()->route('home');
});


// Sesi Registrasi
Route::get('/daftar_mahasiswa_1', [RegisterAkun::class, 'showRegister'])->name('register');
Route::post('/daftar_mahasiswa_1', [RegisterAkun::class, 'register'])->name('register.post');

// Sesi Login
Route::get('/login', [Login::class, 'showLogin'])->name('login');
Route::post('/login', [Login::class, 'login'])->name('login.post');
Route::post('/logout', [Login::class, 'logout'])->name('logout');

//Dashboard Freelancer
Route::get('/dashboard_freelance', [FreelancerDashboard::class, 'index'])
    ->name('dashboard_freelance')
    ->middleware('auth');

//Profil Page & Jelajahi Proyek
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::get('/freelancer/profile', [ProfileController::class, 'index'])->name('freelancer.profile');
    Route::get('/freelancer/edit', [ProfileController::class, 'edit'])->name('freelancer.edit');
    Route::put('/freelancer/profile/update', [ProfileController::class, 'update'])->name('freelancer.update');
    
    // Switch Role
    Route::get('/switch-role/{role}', function ($role) {
        if (in_array($role, ['Freelancer', 'UMKM'])) {
            session()->put('active_role', $role);
        }
        return redirect()->route('profil');
    })->name('switch.role');
    
    Route::get('/jelajahi_proyek', [ProjectController::class, 'index'])->name('jelajahi_proyek');
});

//Daftar UMKM
Route::middleware(['auth'])->group(function () {
    // Kelompok Rute Fitur UMKM
    Route::prefix('umkm')->name('umkm.')->group(function () {
        // Dashboard UMKM
        Route::get('/dashboard', [UMKMDashboardController::class, 'index'])->name('dashboard');
        
        // Profil / Detail UMKM
        Route::get('/profile', [UmkmProfileController::class, 'index'])->name('profile');
        
        // Pendaftaran UMKM
        Route::get('/register', [UmkmProfileController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [UmkmProfileController::class, 'processRegister'])->name('register.process');
        
        // Manajemen Pembuatan Proyek Baru oleh UMKM
        Route::get('/create-project', [UmkmProfileController::class, 'create'])->name('project.umkm.create');
        Route::post('/project', [UmkmProfileController::class, 'store'])->name('project.umkm.store');
    });
});

// Admin Panel Rute
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/grafik', [AdminController::class, 'indexGrafik'])->name('admin.grafik.index');
    Route::put('/admin/update/{user_id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy/{user_id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Rute Menu UMKM
    Route::get('/admin/umkm', [AdminController::class, 'indexUmkm'])->name('admin.umkm.index');
    Route::put('/admin/umkm/update/{id}', [AdminController::class, 'updateUmkm'])->name('admin.umkm.update');
    Route::delete('/admin/umkm/destroy/{id}', [AdminController::class, 'destroyUmkm'])->name('admin.umkm.destroy');

    // Rute Menu Project / Proyek
    Route::get('/admin/umkm/proyek', [AdminController::class, 'indexProject'])->name('admin.project.index');
    Route::put('/admin/umkm/proyek/update/{id}', [AdminController::class, 'updateProject'])->name('admin.project.update');
    Route::delete('/admin/umkm/proyek/destroy/{id}', [AdminController::class, 'destroyProject'])->name('admin.project.destroy');

    // Rute Admin Reports & Cancellations
    Route::get('/admin/reports', [AdminReportController::class, 'reportsList'])->name('admin.reports.list');
    Route::get('/admin/cancellations', [AdminReportController::class, 'cancellationsList'])->name('admin.cancellations.list');
    Route::put('/admin/report/{report_id}/status', [AdminReportController::class, 'updateReportStatus'])->name('admin.report.status');
    Route::put('/admin/cancellation/{cancellation_id}/status', [AdminReportController::class, 'updateCancellationStatus'])->name('admin.cancellation.status');
});

// Rute Buat Proyek & Detail Proyek
Route::middleware(['auth'])->group(function () {
    Route::get('/project/create', [BuatProyekController::class, 'create'])->name('project.create');
    Route::post('/project/store', [BuatProyekController::class, 'store'])->name('project.store');
    Route::get('/project/{project_id}', [DetailProyekController::class, 'show'])->name('project.show');
});

// Rute Project Applicants (Pelamar Proyek) & Actions
Route::middleware(['auth'])->group(function () {
    // Submit aplikasi pelamar
    Route::post('/project/{project_id}/apply', [ProjectApplicantController::class, 'store'])->name('project.apply');
    
    // Tampilkan daftar pelamar untuk UMKM
    Route::get('/project/{project_id}/applicants', [ProjectApplicantController::class, 'listApplicants'])->name('project.applicants');
    
    // Terima/tolak pelamar
    Route::put('/applicant/{application_id}/accept', [ProjectApplicantController::class, 'accept'])->name('applicant.accept');
    Route::put('/applicant/{application_id}/reject', [ProjectApplicantController::class, 'reject'])->name('applicant.reject');
    Route::delete('/applicant/{application_id}', [ProjectApplicantController::class, 'destroy'])->name('applicant.destroy');
    Route::post('/applicant/withdraw', [ProjectApplicantController::class, 'withdraw'])->name('applicant.withdraw');
    
    // Report UMKM/Freelancer
    Route::post('/project/{project_id}/report', [ReportController::class, 'store'])->name('project.report');
    
    // Cancel Project (FIX 2: Sekarang controllernya dijamin terbaca!)
    Route::post('/project/{project_id}/cancel', [ProjectCancellationController::class, 'store'])->name('project.cancel');

    // Progress Monitoring
    Route::get('/project/{project_id}/progress', [ProjectProgressController::class, 'show'])->name('project.progress');
    Route::post('/project/{project_id}/progress/stage', [ProjectProgressController::class, 'updateStage'])->name('project.progress.stage');
    Route::post('/project/{project_id}/progress/submit', [ProjectProgressController::class, 'submitWork'])->name('project.progress.submit');
    Route::post('/project/{project_id}/progress/complete', [ProjectProgressController::class, 'completeProject'])->name('project.progress.complete');
    
    // Halaman Pembayaran Proyek
    Route::get('/project/{project_id}/payment', [ProjectProgressController::class, 'showPayment'])->name('project.payment');
    Route::post('/project/{project_id}/payment', [ProjectProgressController::class, 'uploadPaymentProof'])->name('project.payment.submit');
    Route::post('/project/{project_id}/payment/rate', [ProjectProgressController::class, 'submitRating'])->name('project.payment.rate');
});