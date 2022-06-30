<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PubliciteController;
use App\Http\Controllers\SouscriptionController;
use App\Http\Controllers\SouscriptionUtilisateurController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ApiAdminAuthController;
use App\Http\Controllers\ApiAuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth.api_token:user')->group(function () {
    Route::prefix('utilisateur')->group(function () {
        
        Route::post('posts', [UtilisateurController::class, 'storePost']);
        Route::put('posts/{post}', [UtilisateurController::class, 'updatePost']);
        Route::delete('posts/{post}', [UtilisateurController::class, 'destroyPost']);
    });    
});

Route::post('admin-login', [ApiAdminAuthController::class, 'login']);
Route::post('login', [ApiAuthController::class, 'login']);
Route::post('logout', [ApiAuthController::class, 'logout']);

Route::get('home', [HomeController::class, 'index']);

Route::get('utilisateurs/{utilisateur}/posts', [UtilisateurController::class, 'posts']);
Route::get('utilisateurs/{utilisateur}', [UtilisateurController::class, 'show']);
Route::post('utilisateurs/{utilisateur}', [UtilisateurController::class, 'update']);
Route::delete('utilisateurs/{utilisateur}', [UtilisateurController::class, 'destroy']);
Route::get('utilisateurs', [UtilisateurController::class, 'index']);
Route::post('utilisateurs', [UtilisateurController::class, 'store']);
Route::post('upload', [FileUploadController::class, 'store']);

Route::get('administrateurs', [AdministrateurController::class, 'index']);
Route::post('administrateurs', [AdministrateurController::class, 'store']);
Route::get('administrateurs/{administrateur}', [AdministrateurController::class, 'show']);
Route::put('administrateurs/{administrateur}', [AdministrateurController::class, 'update']);
Route::delete('administrateurs/{administrateur}', [AdministrateurController::class, 'destroy']);

Route::get('categories', [CategorieController::class, 'index']);
Route::post('categories', [CategorieController::class, 'store']);
Route::get('categories/{categorie}', [CategorieController::class, 'show']);
Route::get('categories/{categorie}/posts', [CategorieController::class, 'posts']);
Route::post('categories/{categorie}', [CategorieController::class, 'update']);
Route::delete('categories/{categorie}', [CategorieController::class, 'destroy']);

Route::get('promotions', [PromotionController::class, 'index']);
Route::post('promotions', [PromotionController::class, 'store']);
Route::get('promotions/{promotion}', [PromotionController::class, 'show']);
Route::put('promotions/{promotion}', [PromotionController::class, 'update']);
Route::delete('promotions/{promotion}', [PromotionController::class, 'destroy']);

Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::put('posts/{post}', [PostController::class, 'update']);
Route::delete('posts/{post}', [PostController::class, 'destroy']);

Route::get('notifications', [NotificationController::class, 'index']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::get('notifications/{notification}', [NotificationController::class, 'show']);
Route::put('notifications/{notification}', [NotificationController::class, 'update']);
Route::delete('notifications/{notification}', [NotificationController::class, 'destroy']);

Route::get('publicites', [PubliciteController::class, 'index']);
Route::post('publicites', [PubliciteController::class, 'store']);
Route::get('publicites/{publicite}', [PubliciteController::class, 'show']);
Route::put('publicites/{publicite}', [PubliciteController::class, 'update']);
Route::delete('publicites/{publicite}', [PubliciteController::class, 'destroy']);

Route::get('souscriptions', [SouscriptionController::class, 'index']);
Route::post('souscriptions', [SouscriptionController::class, 'store']);
Route::get('souscriptions/{souscription}', [SouscriptionController::class, 'show']);
Route::post('souscriptions/{souscription}', [SouscriptionController::class, 'update']);
Route::delete('souscriptions/{souscription}', [SouscriptionController::class, 'destroy']);

Route::get('souscription_utilisateurs', [SouscriptionUtilisateurController::class, 'index']);
Route::post('souscription_utilisateurs', [SouscriptionUtilisateurController::class, 'store']);
Route::get('souscription_utilisateurs/{souscription_utilisateur}', [SouscriptionUtilisateurController::class, 'show']);
Route::put('souscription_utilisateurs/{souscription_utilisateur}', [SouscriptionUtilisateurController::class, 'update']);
Route::delete('souscription_utilisateurs/{souscription_utilisateur}', [SouscriptionUtilisateurController::class, 'destroy']);


