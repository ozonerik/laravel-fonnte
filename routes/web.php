<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('messages', MessageController::class);
    Route::resource('devices', DeviceController::class);

    Route::post('send-message', [DeviceController::class, 'sendMessage'])->name('send.message');
    Route::post('devices/status', [DeviceController::class, 'checkDeviceStatus']);
    Route::post('devices/activate', [DeviceController::class, 'activateDevice'])->name('devices.activate');
    Route::post('devices/request-otp', [DeviceController::class, 'requestOTPForDeleteDevice'])->name('devices.requestOtp');
    Route::post('devices/submit-otp', [DeviceController::class, 'submitOTPForDeleteDevice'])->name('devices.submitOTP');
});

require __DIR__ . '/auth.php';
