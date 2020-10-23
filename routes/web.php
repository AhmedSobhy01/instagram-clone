<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;

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

Auth::routes();

/*
|--------------------------------------------------------------------------
| Ajax URLs
|--------------------------------------------------------------------------
*/

Route::patch('/profile/image', [ProfileController::class, 'changeImage'])->name('profile.changeImage');
Route::post('/search', [SearchController::class, 'users'])->name('search');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::post('/user/follow', [UserController::class, 'follow'])->name('follow.store');
Route::post('/user/followers', [UserController::class, 'getFollowers'])->name('user.followers');
Route::post('/user/followings', [UserController::class, 'getFollowing'])->name('user.followings');
Route::post('/p/likes', [PostController::class, 'getLikes'])->name('like.index');
Route::delete('/p/delete', [PostController::class, 'delete'])->name('post.delete');
Route::get('/p/{post}', [PostController::class, 'index'])->name('post.index');
Route::post('/like', [PostController::class, 'like'])->name('like.store');
Route::get('/comment', [PostController::class, 'getComments'])->name('comment.index');
Route::post('/comment', [PostController::class, 'comment'])->name('comment.store');

/*
|--------------------------------------------------------------------------
| End Ajax URLs
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth', 'prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
});

Route::group(['middleware' => 'auth', 'as' => 'account.'], function () {
    Route::get('/account', [UserController::class, 'edit'])->name('edit');
    Route::patch('/account', [UserController::class, 'update'])->name('update');
});

Route::post('/p', [PostController::class, 'upload'])->name('post.store')->middleware("auth");

Route::get('/', [HomeController::class, 'index'])->middleware("auth")->name('home');
Route::get('/{username}', [ProfileController::class, 'index'])->name('profile');