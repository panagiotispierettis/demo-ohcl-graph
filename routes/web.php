<?php

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

Route::get('/service/stock-data/info', 'GetStockData@info');
Route::get('/service/stock-data/prices', 'GetStockData@prices');

Route::get('/test-command',function(){
  $exitCode = Artisan::call('populatedb');
});
