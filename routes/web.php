<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterStep1Controller;
use App\Http\Controllers\Auth\RegisterStep2Controller;
use App\Http\Controllers\Auth\RegisterStep3Controller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/register', [RegisterStep1Controller::class, 'show'])->name('register');
Route::post('/register/step1', [RegisterStep1Controller::class, 'submit'])->name('register.submit.step1');
Route::get('/register/step1', [RegisterStep1Controller::class, 'show'])->name('register.step1');
Route::get('/register/step2', [RegisterStep2Controller::class, 'show'])->name('register.step2');
Route::post('/register/step2', [RegisterStep2Controller::class, 'submit'])->name('register.submit.step2');
Route::get('/register/step3', [RegisterStep3Controller::class, 'show'])->name('register.step3');
Route::post('/register/step3', [RegisterStep3Controller::class, 'submit'])->name('register.submit.step3');
Route::get('/about', function () {
    return view('about');
});
