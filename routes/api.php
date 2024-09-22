<?php

use App\Http\Controllers\API\V1\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Articles
Route::get('articles', [ArticleController::class,'index']);
