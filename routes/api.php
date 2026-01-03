<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\GigController as ApiGigController;
use App\Http\Controllers\Api\TierController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\FavoriteController;

Route::prefix('v1')->group(function () {
    // Public routes with rate limiting
    Route::middleware('throttle:100,1')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1');
            Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1');
        });

        // Get gigs without authentication
        Route::get('/gigs', [ApiGigController::class, 'index']);
        Route::get('/gigs/{id}', [ApiGigController::class, 'show']);

        // Get categories
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/categories/{id}', [CategoryController::class, 'show']);
        Route::get('/categories/popular', [CategoryController::class, 'popular']);

        // Get handyman reviews (public)
        Route::get('/handymen/{handyman_id}/reviews', [ReviewController::class, 'getHandymanReviews']);

        // Get countries and cities
        Route::get('/countries', [UserController::class, 'getCountries']);
        Route::get('/cities/{country_id}', [UserController::class, 'getCities']);
    });

    // Protected routes
    Route::middleware(['auth:sanctum', 'throttle:200,1'])->group(function () {
        // Auth
        Route::post('/auth/logout', [LogoutController::class, 'logout']);

        // User routes
        Route::get('/user', [UserController::class, 'getCurrentUser']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::post('/user/avatar', [UserController::class, 'uploadAvatar']);

        // Handyman routes
        Route::post('/user/become-handyman', [UserController::class, 'becomeHandyman']);
        Route::get('/user/handyman-profile', [UserController::class, 'getHandymanProfile']);
        Route::put('/user/handyman-profile', [UserController::class, 'updateHandymanProfile']);

        // Gigs routes
        Route::post('/gigs', [ApiGigController::class, 'store']);
        Route::put('/gigs/{id}', [ApiGigController::class, 'update']);
        Route::delete('/gigs/{id}', [ApiGigController::class, 'destroy']);
        Route::get('/my-gigs', [ApiGigController::class, 'myGigs']);
        Route::post('/gigs/{id}/apply', [ApiGigController::class, 'apply']);

        // Pricing Tiers routes
        Route::get('/gigs/{gigId}/tiers', [TierController::class, 'getTiersByGig']);
        Route::post('/tiers', [TierController::class, 'store']);
        Route::put('/tiers/{id}', [TierController::class, 'update']);
        Route::delete('/tiers/{id}', [TierController::class, 'destroy']);

        // Orders routes
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);
        Route::put('/orders/{id}', [OrderController::class, 'update']);
        Route::post('/orders/{id}/accept', [OrderController::class, 'accept']);
        Route::post('/orders/{id}/reject', [OrderController::class, 'reject']);
        Route::post('/orders/{id}/complete', [OrderController::class, 'complete']);
        Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);

        // Reviews routes
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{id}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
        Route::post('/reviews/{id}/respond', [ReviewController::class, 'respond']);

        // Categories routes (admin only - add middleware later)
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // Notifications routes
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
        Route::delete('/notifications/read-all', [NotificationController::class, 'deleteAllRead']);

        // Favorites routes
        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::delete('/favorites', [FavoriteController::class, 'destroy']);
        Route::get('/favorites/check', [FavoriteController::class, 'check']);

        // Chat routes
        Route::post('/conversations/start', [ChatController::class, 'startConversation']);
        Route::get('/conversations', [ChatController::class, 'getConversations']);
        Route::get('/conversations/{id}', [ChatController::class, 'getConversation']);
        Route::post('/conversations/{id}/messages', [ChatController::class, 'sendMessage']);
        Route::get('/conversations/{id}/messages', [ChatController::class, 'getMessages']);
    });
});

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
    ]);
});
