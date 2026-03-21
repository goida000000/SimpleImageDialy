<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;

Route::resource('diaries', DiaryController::class);
Route::get('/', [DiaryController::class,'index']);
Route::post('/diaries/confirm', [DiaryController::class, 'confirm'])->name('diaries.confirm');
// Route::post('/diaries/{id}/confirm', [DiaryController::class, 'confirmUpdate'])->name('diaries.confirmUpdate');
Route::match(['put', 'post', 'get'], '/diaries/{id}/confirm', [DiaryController::class, 'confirmUpdate'])->name('diaries.confirmUpdate');

Route::redirect('/', '/diaries');