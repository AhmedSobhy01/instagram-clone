<?php

use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;

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

// #########################################
// Ajax API
Route::post('/search', [SearchController::class, 'users'])->name('search');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::post('/user/follow', [UserController::class, 'follow'])->name('follow');
Route::get('/p/likes', [PostController::class, 'getLikes'])->name('like.index');
Route::get('/p/{post}', [PostController::class, 'index'])->name('post.index');
Route::post('/like', [PostController::class, 'like'])->name('like.create');
Route::get('/comment', [PostController::class, 'getComments'])->name('comment.index');
Route::post('/comment', [PostController::class, 'comment'])->name('comment.create');
// #########################################

Route::group(['middleware' => 'auth', 'prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
});

Route::get('/', [HomeController::class, 'index'])->middleware("auth")->name('home');
Route::get('/{username}', [ProfileController::class, 'index'])->name('profile');

Route::post('/p', [PostController::class, 'upload'])->name('post.store')->middleware("auth");