<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CandidatController,
    RecruteurController,
    AdminController,
    OffreEmploiController,
    CandidatureController,
    CompetenceController,
    DocumentController,
    NotificationController
};

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

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});

// Authentification
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
    
    // Choix du type de compte
    Route::get('/register/type', 'showAccountTypeSelection')->name('register.type');
});

// Routes d'authentification (mot de passe oublié, réinitialisation, etc.)
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');
});

// Routes pour candidats
Route::middleware(['auth', \App\Http\Middleware\Role::class . ':candidat'])->prefix('candidat')->group(function () {
    Route::get('/dashboard', [CandidatController::class, 'dashboard'])->name('candidat.dashboard');
    
    // Gestion du profil
    Route::get('/profil', [CandidatController::class, 'showProfile'])->name('candidat.profil');
    Route::put('/profil/update', [CandidatController::class, 'updateProfile'])->name('candidat.profil.update');
    
    // Gestion des compétences
    Route::resource('competences', CompetenceController::class)->except(['show']);
    
    // Gestion des documents
    Route::resource('documents', DocumentController::class);
    
    // Consultation et postulation aux offres
    Route::get('/offres', [OffreEmploiController::class, 'index'])->name('candidat.offres');
    Route::get('/offres/{offre}', [OffreEmploiController::class, 'show'])->name('candidat.offres.show');
    Route::post('/offres/{offre}/postuler', [CandidatureController::class, 'store'])->name('candidat.postuler');
    
    // Gestion des candidatures
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidat.candidatures');
    Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show'])->name('candidat.candidatures.show');
    Route::delete('/candidatures/{candidature}', [CandidatureController::class, 'destroy'])->name('candidat.candidatures.destroy');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('candidat.notifications');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('candidat.notifications.read');
});

// Routes pour recruteurs
Route::middleware(['auth', \App\Http\Middleware\Role::class . ':recruteur'])->prefix('recruteur')->group(function () {
    Route::get('/dashboard', [RecruteurController::class, 'dashboard'])->name('recruteur.dashboard');
    
    // Gestion du profil
    Route::get('/profil', [RecruteurController::class, 'showProfile'])->name('recruteur.profil');
    Route::put('/profil/update', [RecruteurController::class, 'updateProfile'])->name('recruteur.profil.update');
    
    // Gestion des offres d'emploi
    Route::resource('offres', OffreEmploiController::class);
    Route::get('/offres', [RecruteurController::class, 'mesOffres'])->name('recruteur.offres');
    
    // Gestion des candidatures
    Route::get('/offres/{offre}/candidatures', [RecruteurController::class, 'candidaturesOffre'])->name('recruteur.candidatures');
    Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show'])->name('recruteur.candidatures.show');
    Route::put('/candidatures/{candidature}/status', [CandidatureController::class, 'updateStatus'])->name('recruteur.candidatures.status');
    
    // Recherche de candidats
    Route::get('/recherche', [CandidatController::class, 'search'])->name('recruteur.recherche');
    Route::get('/candidats/{candidat}', [CandidatController::class, 'show'])->name('recruteur.candidats.show');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('recruteur.notifications');
});

// Routes pour administrateurs
Route::middleware(['auth', \App\Http\Middleware\Role::class . ':admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Gestion des utilisateurs
    Route::resource('utilisateurs', AdminController::class);
    
    // Gestion des offres (validation)
    Route::get('/offres', [OffreEmploiController::class, 'adminIndex'])->name('admin.offres');
    Route::put('/offres/{offre}/validate', [OffreEmploiController::class, 'validateOffer'])->name('admin.offres.validate');
    Route::put('/offres/{offre}/reject', [OffreEmploiController::class, 'rejectOffer'])->name('admin.offres.reject');
    
    // Statistiques
    Route::get('/statistiques', [AdminController::class, 'statistics'])->name('admin.statistiques');
    
    // Gestion des compétences
    Route::resource('competences', CompetenceController::class)->except(['show', 'create', 'store']);
});

// Routes API pour autocomplétion, etc.
Route::middleware('auth')->group(function () {
    Route::get('/api/competences/search', [CompetenceController::class, 'search'])->name('api.competences.search');
});

