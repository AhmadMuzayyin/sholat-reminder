<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::controller(HomeController::class)->group(function () {
    Route::get('getLocation', 'getLocation');
    Route::get('setLocation', 'setLocation');
    Route::get('getAlarm', 'getAlarm');
    Route::get('setAlarm', 'setAlarm');
    Route::get('deleteAlarm', 'deleteAlarm');
    Route::get('triggerAlarm', 'triggerAlarm');
});
