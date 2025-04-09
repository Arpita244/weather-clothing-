<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClothingImageController;


Route::get('/', [ClothingImageController::class, 'generateImage']);

Route::post('/', [ClothingImageController::class, 'generateImage']);