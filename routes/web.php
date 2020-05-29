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

Route::get('/', 'HomeController@deviceCheck')->name('home')->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/change/', 'ReservationController@change')->name('change')->middleware('auth');
Route::get('/reservations/all', 'ReservationController@showAll')->name('all')->middleware('auth');



Route::get('/reservations/group', 'ReservationController@showGroups')->name('showGroups')->middleware('auth');
Route::get('/reservations/restaurant', 'ReservationController@showRestaurant')->name('showRestaurant')->middleware('auth');




Route::resource('/reservations', 'ReservationController')->middleware('auth');



