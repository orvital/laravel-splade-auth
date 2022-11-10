<?php

use Illuminate\Support\Facades\Route;
use Orvital\Auth\Http\Controllers\AuthenticatedSessionController;
use Orvital\Auth\Http\Controllers\ConfirmablePasswordController;
use Orvital\Auth\Http\Controllers\EmailVerificationController;
use Orvital\Auth\Http\Controllers\NewPasswordController;
use Orvital\Auth\Http\Controllers\PasswordResetLinkController;
use Orvital\Auth\Http\Controllers\RegisteredUserController;
use Orvital\Auth\Http\Controllers\VerifyEmailController;
use Orvital\Auth\Invites\Http\Controllers\InviteAcceptController;
use Orvital\Auth\Invites\Http\Controllers\InviteRequestController;

Route::middleware('guest')->group(function () {
    Route::controller(InviteRequestController::class)->group(function () {
        Route::get('invite-request', 'create')->name('invite.request');
        Route::post('invite-request', 'store');
    });

    Route::controller(InviteAcceptController::class)->group(function () {
        Route::get('invite-accept/{token}', 'create')->name('invite.accept');
        Route::post('invite-accept', 'store')->name('invite.update');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationController::class, 'create'])->name('verification.notice');
    Route::post('verify-email', [EmailVerificationController::class, 'store'])->middleware('throttle:6,1');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('throttle:6,1');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
