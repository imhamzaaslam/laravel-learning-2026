<?php

use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/users', UsersController::class.'@index');
Route::post('/users', UsersController::class.'@store');

Route::get('/tasks', TasksController::class.'@index');
Route::post('/tasks', TasksController::class.'@store');
Route::delete('/tasks/{id}', TasksController::class.'@destroy');
