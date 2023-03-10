<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/posts', [UserController::class, 'posts'])->name('user.posts');
});


Route::get('/', [BlogPostController::class, 'index'])->name('posts.list');
Route::get('/blog/{post}', [BlogPostController::class, 'show'])->name('posts.view');
Route::middleware('auth')->group(function () {
    Route::get('/blog/create/post', [BlogPostController::class, 'create'])->name('posts.create');
    Route::post('/blog/create/post', [BlogPostController::class, 'store'])->name('posts.store');
});

require __DIR__ . '/auth.php';
