<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;

// 
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminNewsController;
use App\Http\Controllers\AdminPageController;

// image
use App\Http\Controllers\ImageUploadController;

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

Route::group(['middleware' => 'admin:api'], function () {

    // news
    Route::get( 'admin/get-news', [AdminNewsController::class, 'index'] );
    Route::post( 'admin/get-news-item', [AdminNewsController::class, 'show'] );    
    Route::post( 'admin/news/create', [AdminNewsController::class, 'store'] );
    Route::post( 'admin/news/edit/{id}', [AdminNewsController::class, 'update'] );
    Route::post( 'admin/news/destroy/{id}', [AdminNewsController::class, 'destroy'] );

    // pages
    Route::get( 'admin/get-pages', [AdminPageController::class, 'index'] );
    Route::post( 'admin/pages/create', [AdminPageController::class, 'store'] );
    Route::post( 'admin/get-page', [AdminPageController::class, 'show'] );
    Route::post( 'admin/pages/edit/{id}', [AdminPageController::class, 'update'] );

    // todo
    Route::post( 'admin/image-upload', [ImageUploadController::class, 'saveImage'] );   

});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});

// get news
Route::get('get-news', [NewsController::class, 'index'] );

// get news item
Route::post('get-news-item', [NewsController::class, 'show'] );

// pages
// Route::get( 'get-available-pages', [PageController::class, 'index'] );
Route::post('get-page/{slug}', [PageController::class, 'show'] );