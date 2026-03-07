<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Track;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/tracks', function () {
    $tracks = Track::orderBy('order')->get();
    return view('tracks.index', compact('tracks'));
})->name('tracks.index');

Route::get('/tracks/{track:slug}', function (Track $track) {
    return view('tracks.show', compact('track'));
})->name('tracks.show');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('courses', App\Http\Controllers\User\CourseController::class);
    
    Route::resource('courses.topics', App\Http\Controllers\User\TopicController::class)
        ->shallow();
    
    Route::resource('topics.attempts', App\Http\Controllers\User\AttemptController::class)
        ->only(['create', 'store', 'show']);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';