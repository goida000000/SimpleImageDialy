<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

Route::resource('diaries', DiaryController::class);
Route::get('/', [DiaryController::class,'index']);
Route::redirect('/', '/diaries');