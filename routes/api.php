<?php

use App\Http\Controllers\API\V1\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Articles v1
Route::prefix('v1')->group(function() {
    Route::get('articles', [ArticleController::class,'index']);
    Route::post('store-article', [ArticleController::class,'store'])->middleware('api');
    Route::get('article/{id}', [ArticleController::class,'show']);
});
