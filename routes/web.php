<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-address-list', [ \App\Http\Controllers\MapController::class, 'addressAutocomplete']);
Route::get('/get-address-distance', [ \App\Http\Controllers\MapController::class, 'addressDistance']);
