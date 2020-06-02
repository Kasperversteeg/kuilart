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


Route::get('test', function()
{
	//testpage
});


Route::get('/', 'HomeController@deviceCheck')->name('home')->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

// van periode veranderen
Route::get('/change/', 'ReservationController@change')->name('change')->middleware('auth');
Route::get('/bowling/change', 'BowlingController@change')->name('bowling.change')->middleware('auth');

// veranderen naar groupscontroller in de toekomst
Route::get('/groups/create', 'ReservationController@createGroup')->middleware('auth')->name('groups.create');
Route::post('/groups/store', 'ReservationController@storeGroup')->middleware('auth')->name('groups.store');
Route::get('/groups/{group}/edit', 'ReservationController@edit')->middleware('auth')->name('groups.edit');
Route::get('/groups/{group}', 'ReservationController@updateGroup')->middleware('auth')->name('groups.update');

Route::get('/reservations/all', 'ReservationController@showAll')->name('showAll')->middleware('auth');
Route::get('/reservations/group', 'ReservationController@showGroups')->name('showGroups')->middleware('auth');
Route::get('/reservations/restaurant', 'ReservationController@showRestaurant')->name('showRestaurant')->middleware('auth');


Route::post('/reservations/{id}/updateTable', 'ReservationController@updateTableNr')->name('updateTableNr');

Route::resource('/reservations', 'ReservationController')->middleware('auth');

Route::resource('/bowling', 'BowlingController')->middleware('auth');