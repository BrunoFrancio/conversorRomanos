<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RomanNumeralController;

Route::get('/', function () {
    return view('index');
});

Route::post('/convert', [RomanNumeralController::class, 'manipularConversao']);