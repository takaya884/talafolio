<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CronController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// メモ機能のルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/memo', NoteController::class);
    Route::post('/memo/{noteId}/add-page', [NoteController::class, 'addPage'])->name('memo.add-page');
});

// ニュース関連のルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/category/{category}', [NewsController::class, 'category'])->name('news.category');
    Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
});

// セッション関連のルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/session', [SessionController::class, 'index'])->name('session.index');
    Route::post('/session/store', [SessionController::class, 'store'])->name('session.store');
    Route::delete('/session/{key}', [SessionController::class, 'destroy'])->name('session.destroy');
    Route::post('/session/clear', [SessionController::class, 'clear'])->name('session.clear');
    Route::post('/session/regenerate', [SessionController::class, 'regenerate'])->name('session.regenerate');
});

Route::get('/send-email', [EmailController::class, 'showForm'])->name('show.email.form');
Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');

// Cron関連のルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cron', [CronController::class, 'index'])->name('cron.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
