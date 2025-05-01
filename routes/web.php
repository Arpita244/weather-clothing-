<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClothingImageController;
use App\Http\Controllers\HeartedOutfitController;

Route::get('/', [ClothingImageController::class, 'generateImage'])->middleware('auth');
Route::post('/', [ClothingImageController::class, 'generateImage'])->middleware('auth');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::post('/heart-outfit', [HeartedOutfitController::class, 'heartOutfit']);
    Route::post('/unheart-outfit', [HeartedOutfitController::class, 'unheartOutfit']);
    Route::get('/home', [HeartedOutfitController::class, 'getHeartedOutfits'])->name('home');
});
