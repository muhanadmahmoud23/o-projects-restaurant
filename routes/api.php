<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationContoller;
use App\Http\Controllers\MealsContoller;
use App\Http\Controllers\OrderContoller;
use App\Http\Controllers\InvoiceContoller;

Route::get('availability', [ReservationContoller::class , 'check_availability']);
Route::get('reserve', [ReservationContoller::class , 'Reserve']);
Route::get('allmeals', [MealsContoller::class , 'allmeals']);
Route::get('order', [OrderContoller::class , 'order']);
Route::get('print', [InvoiceContoller::class , 'print']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
