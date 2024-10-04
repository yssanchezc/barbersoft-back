<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('roles', [RoleController::class, 'index']);
Route::get('roles/{id}', [RoleController::class, 'show']);
Route::post('roles', [RoleController::class, 'store']);
Route::put('roles/{id}', [RoleController::class, 'update']);

Route::get('appointments', [AppointmentController::class, 'index']);
Route::get('appointments/users/{id}', [AppointmentController::class, 'showByUser']);
Route::post('appointments', [AppointmentController::class, 'store']);
Route::put('appointments/update/{id}', [AppointmentController::class, 'update']);
Route::put('appointments/complete/{id}', [AppointmentController::class, 'complete']);
Route::get('appointments/count', [AppointmentController::class, 'count']);

Route::post('users/login', [UserController::class, 'login']);
Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class, 'update']);

Route::get('services', [ServiceController::class, 'index']);
Route::post('services', [ServiceController::class, 'store']);
Route::put('services/{id}', [ServiceController::class, 'update']);
