<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
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

// memo/index.blade.phpの表示のみ
Route::get('/memo',function(){
    return view('memo/index');
})->middleware(['auth','verified'])->name('memo');

Route::redirect('/','/memo');
Route::resource('/memo',NoteController::class);

// ニュース関連のルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/category/{category}', [NewsController::class, 'category'])->name('news.category');
    Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
});

Route::get('/send-email', [EmailController::class, 'showForm'])->name('show.email.form');
Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
