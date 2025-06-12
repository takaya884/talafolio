<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CronController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 認証関連のルート
Route::post('/login', [AuthenticatedSessionController::class, 'apiLogin']);
Route::post('/logout', [AuthenticatedSessionController::class, 'apiLogout'])->middleware('auth:sanctum');

// 認証が必要なルート
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // メモ関連のAPI
    Route::apiResource('memo', NoteController::class);
    Route::post('/memo/{noteId}/add-page', [NoteController::class, 'addPage']);

    // ニュース関連のAPI
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/category/{category}', [NewsController::class, 'category']);
    Route::get('/news/search', [NewsController::class, 'search']);

    // セッション関連のAPI
    Route::get('/session', [SessionController::class, 'index']);
    Route::post('/session/store', [SessionController::class, 'store']);
    Route::delete('/session/{key}', [SessionController::class, 'destroy']);
    Route::post('/session/clear', [SessionController::class, 'clear']);
    Route::post('/session/regenerate', [SessionController::class, 'regenerate']);

    // メール関連のAPI
    Route::get('/email', [EmailController::class, 'index']);
    Route::post('/email', [EmailController::class, 'send']);

    // Cron関連のAPI
    Route::get('/cron', [CronController::class, 'index']);
});
