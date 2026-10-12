<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/', function () {
    return redirect('dashboard');
});




Route::get('user_details', UserController::class . '@userDetails');

Route::get('contact', function () {
    exit("contact page");
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('users', UserController::class . '@usersList')->name('users.list')->middleware('admin-only');
    Route::get('users/create', UserController::class . '@create')->name('users.create')->middleware('admin-only');
    Route::get('tasks', TaskController::class . '@taskList')->name('tasks.list');
    Route::get('tasks/create', TaskController::class . '@create')->name('tasks.create');
    Route::get('tasks/{id}', TaskController::class . '@show')->name('tasks.details');
    Route::get('tasks/{id}/edit', TaskController::class . '@edit')->name('tasks.edit');
    Route::get('tasks/{id}/send-assignment-email', TaskController::class . '@sendAssignmentEmail')->name('tasks.send-assignment-email');
    Route::get('users/{user}/tasks', UserController::class . '@assignedTasks')->name('users.assigned-tasks');
});

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
