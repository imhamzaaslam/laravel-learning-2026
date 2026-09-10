<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('user_details', UserController::class . '@userDetails');

Route::get('contact', function () {
    exit("contact page");
});

Route::get('dashboard', DashboardController::class . '@index');

Route::get('users', UserController::class . '@usersList');
