<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::controller(RegistrationController::class)->group(function () {
    Route::get('/register', 'index')->name('register.index');
    Route::post('/register/store', 'store')->name('register.store');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    // Route::controller(UserController::class)->group(function () {
    //     Route::get('/', 'dashboard');
    // });
});