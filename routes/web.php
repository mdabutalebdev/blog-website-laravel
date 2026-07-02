<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BookController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/category/{slug}', [HomeController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);
Route::get('/logout', [AuthController::class, 'logout']); // Should ideally be POST but keeping original method for now

// Protected Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile', [ProfileController::class, 'update']);

    // Post Routes
    Route::get('/my-blogs', [PostController::class, 'myBlogs']);
    Route::get('/post/create', [PostController::class, 'create']);
    Route::post('/post/store', [PostController::class, 'store']);
    Route::post('/post/upload-image', [PostController::class, 'uploadImage']);
    Route::get('/post/edit/{id}', [PostController::class, 'edit']);
    Route::post('/post/update/{id}', [PostController::class, 'update']);
    Route::post('/post/delete/{id}', [PostController::class, 'delete']);
    
    // AJAX Routes for Comments/Likes
    Route::post('/api/like', [LikeController::class, 'toggle']);
    Route::post('/api/comments', [CommentController::class, 'store']);
    Route::post('/api/comments/like', [CommentController::class, 'toggleLike']);
    
    // Books
    Route::get('/books/upload', [BookController::class, 'upload']);
    Route::post('/books/store', [BookController::class, 'store']);
    
    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'dashboard']);
        Route::post('/admin/post/approve/{id}', [\App\Http\Controllers\AdminController::class, 'approvePost']);
        Route::post('/admin/post/delete/{id}', [\App\Http\Controllers\AdminController::class, 'deletePost']);
        Route::post('/admin/banner/store', [\App\Http\Controllers\AdminController::class, 'storeBanner']);
        Route::post('/admin/banner/update/{id}', [\App\Http\Controllers\AdminController::class, 'updateBanner']);
        Route::post('/admin/banner/delete/{id}', [\App\Http\Controllers\AdminController::class, 'deleteBanner']);
        
        // Settings Routes
        Route::post('/admin/settings/update', [\App\Http\Controllers\AdminController::class, 'updateSettings']);
    });
});

// Public Post/Comment Routes
Route::get('/post/{slug}', [PostController::class, 'show']);
Route::get('/api/comments', [CommentController::class, 'index']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/view', [BookController::class, 'serve']);
