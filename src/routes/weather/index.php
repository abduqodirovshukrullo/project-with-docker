<?php

use App\Http\Controllers\AccuWeatherController;
use App\Http\Controllers\OpenWeatherMapController;
use Illuminate\Support\Facades\Route;

Route::get('/accu-weather/current-weather',[AccuWeatherController::class,'currentWeather'])->name('accuCurrentWeather');
Route::get('/open-weather-map/current-weather',[OpenWeatherMapController::class,'currentWeather'])->name('openCurrentWeather');
