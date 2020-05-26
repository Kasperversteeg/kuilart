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

Route::get('/', 'HomeController@deviceCheck')->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/reservations/create', 'ReservationController@create');
Route::get('/home', 'HomeController@deviceCheck')->name('home')->middleware('auth');
Route::get('/home/desktop', 'ReservationController@index')->name('desktop')->middleware('auth');


Route::get('/change', 'ReservationController@change')->name('change');
Route::get('/reservations/group', 'ReservationController@showGroups')->name('showGroups');
Route::get('/reservations/restaurant', 'ReservationController@showRestaurant')->name('showRestaurant');




Route::resource('/reservations', 'ReservationController')->middleware('auth');


// Route::get('/reservations/restaurant/show/{period}', 'ReservationController@showRestaurant')->name('showRestaurant')->middleware('auth');
// Route::get('/reservations/group/show/{period}', 'ReservationController@showGroups')->name('showGroups')->middleware('auth');


