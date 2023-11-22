<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    return Inertia::render('Home/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/slide', [VuetifyController::class, 'slide'])->name('slide');

Route::prefix('/post')
    ->name('post.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/get-list', [PostController::class, 'getList'])->name('get-list-post');
        Route::get('/create', [PostController::class, 'create'])->name('get-form-post');
        Route::post('/create', [PostController::class, 'store'])->name('store-post');
        Route::get('/{post_id}', [PostController::class, 'show'])->name('show');
        Route::post('/like/{post}', [PostController::class, 'likeSpecificPost'])->name('like-specific-post');
    });

Route::prefix('/comment')
    ->name('comment.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/get-list-comment-in-post', [CommentController::class, 'getList'])->name('get-list-comment-in-post');
        Route::post('/create', [CommentController::class, 'store'])->name('store-comment');
    });


Route::prefix('/user')
    ->name('user.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/edit-avatar', [UserController::class, 'editAvatar'])->name('edit-avatar');
        Route::post('/edit-avatar', [UserController::class, 'storeAvatar'])->name('store-avatar');
        Route::get('/get-user-info', [UserController::class, 'getUserInfo'])->name('get-user-info');
        Route::get('/get-options', [UserController::class, 'getOptions'])->name('get-options');
    });
Route::prefix('/friend')
    ->name('friend.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/add-friend-template', [FriendController::class, 'addFriendTemplate'])->name('add-friend-template');
        Route::get('/get-list', [FriendController::class, 'getList'])->name('get-list');
        Route::post('/send-friend-request', [FriendController::class, 'createFriendRequest'])->name('send-friend-request');
        Route::get('/get-list-friend-request', [FriendController::class, 'getListFriendRequest'])->name('get-list-friend-request');
        Route::put('/handle-friend-request/{friendRequest}', [FriendController::class, 'handleFriendRequest'])->name('handle-friend-request');
    });

Route::prefix('notification')
    ->name('notification.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/get-list-notification', [ NotificationController::class, 'getListByUserId'])->name('get-list-by-user-id');
        Route::post('/store', [ NotificationController::class, 'store'])->name('store');
    });

Route::get('/auth/facebook/callback', function () {
    return "Callback login with facebook";
});
