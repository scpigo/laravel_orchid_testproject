<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/ajax/dadata', [\App\Http\Controllers\AjaxController::class, 'adress']);
Route::post('/ajax/classification', [\App\Http\Controllers\AjaxController::class, 'classification']);
