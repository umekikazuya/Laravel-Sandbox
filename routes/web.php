<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API.
Route::get('/api/only_ajax', [ApiController::class, 'onlyAjax'])->name('api.only_ajax');
Route::get('/api/exclude_ajax', [ApiController::class, 'excludeAjax'])->name('api.exclude_ajax');
