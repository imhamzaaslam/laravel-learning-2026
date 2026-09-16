<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('user_details', UserController::class . '@userDetails');

Route::get('contact', function () {
    exit("contact page");
});

Route::get('dashboard', DashboardController::class . '@index');

Route::get('users', UserController::class . '@usersList')->name('users.list');
Route::get('users/create', UserController::class . '@create')->name('users.create');
Route::get('tasks', TaskController::class . '@taskList')->name('tasks.list');
Route::get('tasks/create', TaskController::class . '@create')->name('tasks.create');
Route::get('tasks/{id}', TaskController::class . '@show')->name('tasks.details');
