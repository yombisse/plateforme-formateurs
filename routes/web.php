<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\InscriptionManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommandationController;
use App\Http\Controllers\TrainerProfileController;
use App\Http\Controllers\VitrineController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VitrineController::class, 'index'])->name('vitrine.index');
Route::get('/formations/{slug}', [VitrineController::class, 'show'])->name('formations.show');
Route::post('/formations/{formation}/inscriptions', [InscriptionController::class, 'store'])->name('inscriptions.store');
Route::get('/dashboard', [VitrineController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/mes-formations', [VitrineController::class, 'mesFormations'])->middleware(['auth', 'verified'])->name('formations.mes');
Route::get('/admin/formations/create', [VitrineController::class, 'createFormation'])->middleware(['auth', 'verified'])->name('admin.formation.create');
Route::post('/admin/formations', [VitrineController::class, 'storeFormation'])->middleware(['auth', 'verified'])->name('admin.formation.store');
Route::get('/admin/formations/{slug}/edit', [VitrineController::class, 'editFormation'])->middleware(['auth', 'verified'])->name('admin.formation.edit');
Route::put('/admin/formations/{slug}', [VitrineController::class, 'updateFormation'])->middleware(['auth', 'verified'])->name('admin.formation.update');
Route::delete('/admin/formations/{slug}', [VitrineController::class, 'destroyFormation'])->middleware(['auth', 'verified'])->name('admin.formation.destroy');
Route::post('/admin/formations/{slug}/publish', [VitrineController::class, 'publishFormation'])->middleware(['auth', 'verified'])->name('admin.formation.publish');
Route::post('/admin/formations/{slug}/unpublish', [VitrineController::class, 'unpublishFormation'])->middleware(['auth', 'verified'])->name('admin.formation.unpublish');
Route::get('/admin/formations/{slug}/poster', [VitrineController::class, 'posterGenerator'])->middleware(['auth', 'verified'])->name('admin.formation.poster');

// Routes de gestion des inscriptions
Route::get('/admin/formations/{formationId}/inscriptions', [InscriptionManagementController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.inscriptions.index');
Route::post('/admin/inscriptions/{id}/accept', [InscriptionManagementController::class, 'accept'])->middleware(['auth', 'verified'])->name('admin.inscriptions.accept');
Route::post('/admin/inscriptions/{id}/reject', [InscriptionManagementController::class, 'reject'])->middleware(['auth', 'verified'])->name('admin.inscriptions.reject');
Route::get('/admin/formations/{formationId}/inscriptions/stats', [InscriptionManagementController::class, 'stats'])->middleware(['auth', 'verified'])->name('admin.inscriptions.stats');

// Routes d'évaluations
Route::post('/formations/{formationId}/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
Route::put('/evaluations/{evaluationId}', [EvaluationController::class, 'update'])->middleware(['auth'])->name('evaluations.update');
Route::delete('/evaluations/{evaluationId}', [EvaluationController::class, 'destroy'])->middleware(['auth'])->name('evaluations.destroy');
Route::get('/formations/{formationId}/evaluations/stats', [EvaluationController::class, 'stats'])->name('evaluations.stats');

// Routes de recommandations
Route::post('/trainers/{trainerId}/recommandations', [RecommandationController::class, 'store'])->name('recommandations.store');
Route::put('/recommandations/{recommandationId}', [RecommandationController::class, 'update'])->middleware(['auth'])->name('recommandations.update');
Route::delete('/recommandations/{recommandationId}', [RecommandationController::class, 'destroy'])->middleware(['auth'])->name('recommandations.destroy');
Route::get('/trainers/{trainerId}/recommandations', [RecommandationController::class, 'index'])->name('recommandations.index');
Route::get('/trainers/{trainerId}/recommandations/stats', [RecommandationController::class, 'stats'])->name('recommandations.stats');

// Routes de gestion du profil formateur
Route::get('/trainer-profile/edit', [TrainerProfileController::class, 'edit'])->middleware(['auth'])->name('trainer-profile.edit');
Route::put('/trainer-profile', [TrainerProfileController::class, 'update'])->middleware(['auth'])->name('trainer-profile.update');
Route::delete('/trainer-profile/profile-photo', [TrainerProfileController::class, 'destroyProfilePhoto'])->middleware(['auth'])->name('trainer-profile.destroy-profile-photo');
Route::delete('/trainer-profile/hero-image', [TrainerProfileController::class, 'destroyHeroImage'])->middleware(['auth'])->name('trainer-profile.destroy-hero-image');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
