<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\TopicController;
use App\Http\Controllers\User\AttemptController;
use App\Models\Track;
use App\Models\Course   ;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tracks', function () {
        $tracks = Track::orderBy('order')->get();
        return view('user.tracks.index', compact('tracks'));
    })->name('tracks.index');

    Route::resource('courses', CourseController::class);
    
    Route::resource('courses.topics', TopicController::class)->shallow();
    
    Route::resource('topics.attempts', AttemptController::class)
        ->only(['create', 'store', 'show']);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';