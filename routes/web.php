<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
define("PREFIX", env('PREFIX','system'));
define("PAGINATION", env('PAGINATION',20));
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);
Route::get('/',function(){
    return view('welcome');
});

Route::get('system','Auth\LoginController@showLoginForm');
Route::get('/system/login','Auth\LoginController@showLoginForm');
Route::post('/system/login','Auth\LoginController@login')->middleware(['throttle:5','log']);
Route::get('/system/logout','Auth\LoginController@logout');


include('backend.php');


// Auth::routes();
