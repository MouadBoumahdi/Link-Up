<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/friends/request/{user}', [FriendController::class, 'send'])->name('friends.request');
Route::get('/friends/search', [FriendController::class, 'search'])->name('friends.search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Add this route
Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
Route::get('/friends/search', [FriendController::class, 'search'])->name('friends.search');
Route::post('/friends/send/{user}', [FriendController::class, 'sendRequest'])->name('friends.send');
Route::post('/friends/accept/{friendship}', [FriendController::class, 'acceptRequest'])->name('friends.accept');
Route::post('/friends/reject/{friendship}', [FriendController::class, 'rejectRequest'])->name('friends.reject');
Route::post('/friends/cancel/{friendship}', [FriendController::class, 'cancelRequest'])->name('friends.cancel');



// Post routes
Route::middleware('auth')->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

});


require __DIR__.'/auth.php';
