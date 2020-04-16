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

Route::any('/test', 'FirstController2@test');
Route::any('/ceshi', 'Ceshi@index');
Route::any('/one', 'Test\OneController@index');
Route::any('/upload', 'FirstController@upload');
Route::any('/import', 'FirstController@import');
Route::any('/export', 'FirstController@export');
Route::any('/second','SecondController@index');