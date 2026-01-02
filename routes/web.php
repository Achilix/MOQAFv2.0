<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterStep1Controller;
use App\Http\Controllers\Auth\RegisterStep2Controller;
use App\Http\Controllers\Auth\RegisterStep3Controller;
use App\Http\Controllers\GigController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;

Route::get('/', function (Request $request) {
    if ($request->query()) {
        $target = auth()->check() ? 'home' : 'services';
        return redirect()->route($target, $request->query());
    }

    return view('welcome');
})->name('landing');

Route::get('/services', [HomeController::class, 'index'])->name('services');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

// Language switching
Route::get('/language/{locale}', [LocalizationController::class, 'setLanguage'])->name('language.switch');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/become-a-handyman', function () {
    return view('become-a-handyman');
})->name('become-handyman');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

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

Route::get('/gigs/{id}', [GigController::class, 'show'])->name('gigs.show');

Route::middleware('auth')->group(function () {
    Route::get('/my-gigs', [GigController::class, 'myGigs'])->name('my-gigs');
    Route::post('/gigs', [GigController::class, 'store'])->name('gigs.store');
    Route::get('/gigs/{id}/edit', [GigController::class, 'edit'])->name('gigs.edit');
    Route::put('/gigs/{id}', [GigController::class, 'update'])->name('gigs.update');
    Route::delete('/gigs/{id}', [GigController::class, 'destroy'])->name('gigs.destroy');

    // Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('my-orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Chat
    Route::post('/conversations/start', [ChatController::class, 'start'])->name('conversations.start');
    Route::get('/conversations', [ChatController::class, 'index'])->name('conversations.list');
    Route::get('/conversations/unread-count', [ChatController::class, 'unreadCount'])->name('conversations.unread');
    Route::get('/conversations/{conversation}', [ChatController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/messages', [ChatController::class, 'storeMessage'])->name('conversations.message');
    Route::get('/conversations/{conversation}/messages', [ChatController::class, 'fetchMessages'])->name('conversations.fetch');
});
