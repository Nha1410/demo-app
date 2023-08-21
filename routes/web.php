<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VuetifyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
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

Route::get('/test', function () {
    return 'test';
});

Route::get('/auth/facebook', function () {
    return Socialite::driver('facebook')->redirect();
});


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/slide', [VuetifyController::class, 'slide'])->name('slide');

Route::prefix('/post')
    ->name('post.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index'); 
        Route::get('/get-list', [PostController::class, 'getList'])->name('get-list-post'); 
        Route::get('/create', [PostController::class, 'create'])->name('get-form-post'); 
        Route::post('/create', [PostController::class, 'store'])->name('store-post'); 
        Route::get('/{post_id}', [PostController::class, 'getSpecificPost'])->name('get-specific-post'); 
    });


Route::get('/auth/facebook/callback', function() {
    return "Callback login with facebook";
});