<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/vkauth', array('uses' => 'AuthController@vkauth'));



//Login
Route::get('/login', array('uses' => 'AuthController@login'));
Route::post('/login', array('uses' => 'AuthController@login'));


//Logout
Route::get('/logout', array('uses' => 'AuthController@logout'));


//Register
Route::get('/register', array('uses' => 'AuthController@register'));
Route::post('/register', array('uses' => 'AuthController@register'));


//Profile
Route::get('/profile', array('before' => 'auth' ,'uses' => 'AuthController@profile'));
