<?php

use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API!']);
});
