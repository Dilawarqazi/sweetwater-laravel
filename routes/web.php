<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

Route::get('/', [CommentController::class, 'index'])->name('comments.index');
Route::post('/update-ship-dates', [CommentController::class, 'updateShipDates'])->name('comments.update_ship_dates');
