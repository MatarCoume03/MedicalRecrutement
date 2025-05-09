<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\RecruteurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OffreEmploiController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes pour l'API RESTful de la plateforme médicale
| Préfixe: /api
| Middleware: api
|
*/

/*---------- Routes Publiques ----------*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/auth/reset-password', [AuthController::class, 'reset']);

// Offres d'emploi publiques
Route::get('/offres', [OffreEmploiController::class, 'index']);
Route::get('/offres/{offre}', [OffreEmploiController::class, 'show']);

// Compétences publiques
Route::get('/competences', [CompetenceController::class, 'index']);
Route::get('/competences/search', [CompetenceController::class, 'search']);

/*---------- Routes Protégées ----------*/
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Authentification
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });

    /*---------- Routes Candidat ----------*/
    Route::prefix('candidat')->middleware('role:candidat')->group(function () {
        // Profil
        Route::get('/profile', [CandidatController::class, 'showProfile']);
        Route::put('/profile', [CandidatController::class, 'updateProfile']);
        
        // Dashboard
        Route::get('/dashboard', [CandidatController::class, 'dashboard']);
        
        // Offres
        Route::get('/offres', [CandidatController::class, 'searchOffres']);
        Route::post('/offres/{offre}/postuler', [CandidatureController::class, 'store']);
        
        // Candidatures
        Route::get('/candidatures', [CandidatureController::class, 'index']);
        Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show']);
        Route::delete('/candidatures/{candidature}', [CandidatureController::class, 'destroy']);
        
        // Documents
        Route::get('/documents', [DocumentController::class, 'index']);
        Route::post('/documents', [DocumentController::class, 'store']);
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy']);
        
        // Compétences
        Route::post('/competences', [CompetenceController::class, 'store']);
        
        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    });

    /*---------- Routes Recruteur ----------*/
    Route::prefix('recruteur')->middleware('role:recruteur')->group(function () {
        // Profil
        Route::get('/profile', [RecruteurController::class, 'showProfile']);
        Route::put('/profile', [RecruteurController::class, 'updateProfile']);
        
        // Dashboard
        Route::get('/dashboard', [RecruteurController::class, 'dashboard']);
        
        // Offres
        Route::get('/offres', [RecruteurController::class, 'mesOffres']);
        Route::post('/offres', [RecruteurController::class, 'storeOffre']);
        Route::get('/offres/{offre}', [RecruteurController::class, 'showOffre']);
        Route::put('/offres/{offre}', [RecruteurController::class, 'updateOffre']);
        Route::delete('/offres/{offre}', [RecruteurController::class, 'destroyOffre']);
        
        // Candidatures
        Route::get('/candidatures', [RecruteurController::class, 'mesCandidatures']);
        Route::get('/offres/{offre}/candidatures', [RecruteurController::class, 'candidaturesOffre']);
        Route::put('/candidatures/{candidature}/status', [RecruteurController::class, 'updateCandidatureStatus']);
        
        // Recherche
        Route::get('/recherche', [RecruteurController::class, 'searchCandidats']);
        Route::get('/candidats/{candidat}', [RecruteurController::class, 'showCandidat']);
    });

    /*---------- Routes Admin ----------*/
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        
        // Utilisateurs
        Route::get('/utilisateurs', [AdminController::class, 'index']);
        Route::put('/utilisateurs/{user}/toggle', [AdminController::class, 'toggleUser']);
        
        // Offres
        Route::get('/offres', [AdminController::class, 'offres']);
        Route::put('/offres/{offre}/validate', [AdminController::class, 'validateOffer']);
        Route::put('/offres/{offre}/reject', [AdminController::class, 'rejectOffer']);
        
        // Statistiques
        Route::get('/statistiques', [AdminController::class, 'statistics']);
        Route::get('/candidatures/statistiques', [CandidatureController::class, 'statistics']);
        
        // Compétences
        Route::get('/competences', [AdminController::class, 'competences']);
        Route::put('/competences/{competence}/validate', [AdminController::class, 'validateCompetence']);
        Route::delete('/competences/{competence}', [AdminController::class, 'destroyCompetence']);
    });
});

/*use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OffreEmploiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
/*Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Offres accessibles sans authentification
Route::get('/offres', [OffreEmploiController::class, 'index']);
Route::get('/offres/{offre}', [OffreEmploiController::class, 'show']);

// Compétences accessibles sans authentification
Route::get('/competences', [CompetenceController::class, 'index']);
Route::get('/competences/search', [CompetenceController::class, 'search']);

// Authenticated routes (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Candidat routes
    Route::prefix('candidat')->group(function () {
        Route::get('/dashboard', [CandidatController::class, 'dashboard']);
        Route::get('/profile', [CandidatController::class, 'showProfile']);
        Route::put('/profile', [CandidatController::class, 'updateProfile']);
        
        // Offres
        Route::get('/offres', [CandidatController::class, 'searchOffres']);
        Route::post('/offres/{offre}/postuler', [CandidatureController::class, 'store']);
        
        // Candidatures
        Route::get('/candidatures', [CandidatureController::class, 'index']);
        Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show']);
        Route::delete('/candidatures/{candidature}', [CandidatureController::class, 'destroy']);
        
        // Documents
        Route::get('/documents', [DocumentController::class, 'index']);
        Route::post('/documents', [DocumentController::class, 'store']);
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy']);
    });
    
    // Routes communes
    Route::apiResource('documents', DocumentController::class)->except(['index', 'store', 'destroy']);
    Route::post('/competences', [CompetenceController::class, 'store']);
});*/

/*
// Authentication routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Candidat routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/candidat/dashboard', [CandidatController::class, 'dashboard']);
    Route::get('/candidat/profile', [CandidatController::class, 'showProfile']);
    Route::put('/candidat/profile', [CandidatController::class, 'updateProfile']);
    Route::get('/candidat/offres', [CandidatController::class, 'searchOffres']);
    Route::get('/candidat/offres/{offre}', [CandidatController::class, 'showOffre']);
    Route::post('/candidat/offres/{offre}/postuler', [CandidatController::class, 'postuler']);
    Route::get('/candidat/candidatures', [CandidatController::class, 'mesCandidatures']);
});

// OffreEmploi routes
Route::get('/offres', [OffreEmploiController::class, 'searchOffres']);
Route::get('/offres/{offre}', [OffreEmploiController::class, 'showOffre']);

// Competence routes
Route::get('/competences', [CompetenceController::class, 'index']);
Route::get('/competences/{competence}', [CompetenceController::class, 'show']);

// Document routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::get('/documents/{document}', [DocumentController::class, 'show']);
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy']);
});*/