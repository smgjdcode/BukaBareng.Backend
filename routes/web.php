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



Route::post('create/users', ['uses' =>'BackendController@createUser']);
Route::post('create/transactions', ['uses' =>'BackendController@createTransaction']);
Route::post('create/payments', ['uses' =>'BackendController@createPayment']);
Route::get('/get/products', ['uses' =>'BackendController@getProducts']);
Route::get('/get/users/{id}', ['uses' =>'BackendController@getUser']);
Route::get('/get/user_transactions/{id}', ['uses' =>'BackendController@getUserTransaction']);


Route::get('/', function () {
//    return view('welcome');
    return "app is running";
});