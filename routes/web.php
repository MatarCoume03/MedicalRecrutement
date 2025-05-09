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

// Password reset routes
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');
});

// Routes pour candidats
Route::middleware(['auth', 'role:candidat'])->prefix('candidat')->name('candidat.')->group(function () {
    Route::get('/dashboard', [CandidatController::class, 'dashboard'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [CandidatController::class, 'showProfile'])->name('profil');
    Route::put('/profil', [CandidatController::class, 'updateProfile'])->name('profil.update');
    
    // Documents
    Route::resource('documents', DocumentController::class)->except(['show']);
    
    // Offres
    Route::get('/offres', [CandidatController::class, 'searchOffres'])->name('offres');
    Route::get('/offres/{offre}', [CandidatController::class, 'showOffre'])->name('offres.show');
    Route::post('/offres/{offre}/postuler', [CandidatController::class, 'postuler'])->name('offres.postuler');
    
    // Candidatures
    Route::get('/candidatures', [CandidatController::class, 'mesCandidatures'])->name('candidatures');
    Route::get('/candidatures/{candidature}', [CandidatController::class, 'showCandidature'])->name('candidatures.show');
    Route::delete('/candidatures/{candidature}', [CandidatController::class, 'annulerCandidature'])->name('candidatures.destroy');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

// Routes pour recruteurs
Route::middleware(['auth', 'role:recruteur'])->prefix('recruteur')->name('recruteur.')->group(function () {
    Route::get('/dashboard', [RecruteurController::class, 'dashboard'])->name('dashboard');
    
    // Profil
    Route::get('/profil', [RecruteurController::class, 'showProfile'])->name('profil');
    Route::put('/profil', [RecruteurController::class, 'updateProfile'])->name('profil.update');
    
    // Offres
    Route::get('/offres', [RecruteurController::class, 'mesOffres'])->name('offres');
    Route::get('/offres/create', [RecruteurController::class, 'createOffre'])->name('offres.create');
    Route::post('/offres', [RecruteurController::class, 'storeOffre'])->name('offres.store');
    Route::get('/offres/{offre}', [RecruteurController::class, 'showOffre'])->name('offres.show');
    Route::get('/offres/{offre}/edit', [RecruteurController::class, 'editOffre'])->name('offres.edit');
    Route::put('/offres/{offre}', [RecruteurController::class, 'updateOffre'])->name('offres.update');
    Route::delete('/offres/{offre}', [RecruteurController::class, 'destroyOffre'])->name('offres.destroy');
    
    // Candidatures
    Route::get('/candidatures', [RecruteurController::class, 'mesCandidatures'])->name('candidatures');
    Route::get('/offres/{offre}/candidatures', [RecruteurController::class, 'candidaturesOffre'])->name('offres.candidatures');
    Route::get('/candidatures/{candidature}', [RecruteurController::class, 'showCandidature'])->name('candidatures.show');
    Route::put('/candidatures/{candidature}/status', [RecruteurController::class, 'updateCandidatureStatus'])->name('candidatures.status');
    
    // Recherche candidats
    Route::get('/recherche', [RecruteurController::class, 'searchCandidats'])->name('recherche');
    Route::get('/candidats/{candidat}', [RecruteurController::class, 'showCandidat'])->name('candidats.show');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
});

// Routes pour administrateurs
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Utilisateurs
    Route::get('/utilisateurs', [AdminController::class, 'index'])->name('users');
    Route::put('/utilisateurs/{user}/toggle', [AdminController::class, 'toggleUser'])->name('users.toggle');
    
    // Offres
    Route::get('/offres', [AdminController::class, 'offres'])->name('offres');
    Route::put('/offres/{offre}/validate', [AdminController::class, 'validateOffer'])->name('offres.validate');
    Route::put('/offres/{offre}/reject', [AdminController::class, 'rejectOffer'])->name('offres.reject');
    
    // Statistiques
    Route::get('/statistiques', [AdminController::class, 'statistics'])->name('statistiques');
    
    // Compétences
    Route::get('/competences', [AdminController::class, 'competences'])->name('competences');
    Route::put('/competences/{competence}/validate', [AdminController::class, 'validateCompetence'])->name('competences.validate');
    Route::delete('/competences/{competence}', [AdminController::class, 'destroyCompetence'])->name('competences.destroy');
});

// Route pour la recherche de compétences (accessible à tous les utilisateurs authentifiés)
Route::middleware('auth')->get('/competences/search', [CompetenceController::class, 'search'])->name('competences.search');

/*use Illuminate\Support\Facades\Route;
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
/*Route::get('/', function () {
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
    Route::get('/offres/create', [RecruteurController::class, 'createOffre'])->name('recruteur.offres.create');
    Route::get('/offres', [RecruteurController::class, 'mesOffres'])->name('recruteur.offres');
    //Route::get('/offres', [RecruteurController::class, 'index'])->name('recruteur.offres.index');
    
    // Gestion des candidatures
    Route::get('/candidatures', [RecruteurController::class, 'mesCandidatures'])->name('recruteur.candidatures');
    //Route::get('/offres/{offre}/candidatures', [RecruteurController::class, 'candidaturesOffre'])->name('recruteur.candidatures');
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
*/
