<?php

use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OTPController::class, 'showPhoneForm']);
Route::post('send-otp', [OTPController::class, 'sendOTP'])->name('send.otp');
Route::get('verify-otp', [OTPController::class, 'showOTPForm'])->name('verify.otp');
Route::post('verify-otp', [OTPController::class, 'verifyOTP']);