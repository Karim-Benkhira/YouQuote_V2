<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ImageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout',[AuthController::class, 'logout']);
    Route::apiResource('quotes', QuoteController::class);
    Route::apiResource('categories', CategorieController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('favoris', FavorisController::class);
    Route::get('quotes/like/{id}', [QuoteController::class, 'LikeQuote']);
    Route::get('quotes/unlike/{id}', [QuoteController::class, 'DislikeQuote']);
});



Route::get('quotes/getByLength/{length}', [QuoteController::class, 'getByLength']);
Route::get('quotes/getPopular/{nb}', [QuoteController::class, 'getPopular']);
Route::get('quotes/getRandom/{nb}', [QuoteController::class, 'getRandom']);



Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);

