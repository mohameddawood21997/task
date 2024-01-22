<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController,App\Http\Controllers\ClientController,App\Http\Controllers\BillController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/get-price', [BillController::class, 'getPrice'])->name('get-price');
Route::resource('products',ProductController::class);
Route::resource('clients',ClientController::class);
Route::resource('bills',BillController::class);
