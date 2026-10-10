<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::get('user_details', UserController::class . '@userDetails');

Route::get('contact', function () {
    exit("contact page");
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('users', UserController::class . '@usersList')->name('users.list');
Route::get('users/create', UserController::class . '@create')->name('users.create');
Route::get('tasks', TaskController::class . '@taskList')->name('tasks.list');
Route::get('tasks/create', TaskController::class . '@create')->name('tasks.create');
Route::get('tasks/{id}', TaskController::class . '@show')->name('tasks.details');
Route::get('tasks/{id}/edit', TaskController::class . '@edit')->name('tasks.edit');
Route::get('tasks/{id}/send-assignment-email', TaskController::class . '@sendAssignmentEmail')->name('tasks.send-assignment-email');

Route::get('users/{user}/tasks', UserController::class . '@assignedTasks')->name('users.assigned-tasks');

Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
