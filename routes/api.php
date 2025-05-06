<?php

use App\Http\Controllers\ShortsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use Illuminate\Support\Facades\DB;


