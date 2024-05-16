<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request)
{
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', 'RegisterController@store');
Route::post('/login', 'LoginController@authenticate');
