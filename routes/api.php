<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('admin/register', [AdminAuthController::class, 'register']);
Route::post('admin/login', [AdminAuthController::class, 'login']);
// Route::post('forgot', [PasswordController::class, 'forgot']);
// Route::post('reset', [PasswordController::class, 'reset']);
Route::middleware(['auth:users,api-users'])->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});
Route::middleware(['auth:admin,api-admin'])->group(function () {
    Route::get('admin/user', [AdminAuthController::class, 'user']);
    Route::post('admin/logout', [AdminAuthController::class, 'logout']);
});
