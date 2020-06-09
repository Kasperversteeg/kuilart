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



// Route::get('/edit/{id}', 'ReservationController@editModal')->middleware('auth');

// home device check first
Route::get('/', 'HomeController@deviceCheck')->name('home')->middleware('auth');

Auth::routes();

// change the shown period 
Route::get('/change/', 'ReservationController@change')->name('change')->middleware('auth');
Route::get('/bowling/change', 'BowlingController@change')->name('bowling.change')->middleware('auth');

// Groupscontroller 
Route::get('/groups/create', 'GroupController@create')->middleware('auth')->name('groups.create');
Route::post('/groups/store', 'GroupController@store')->middleware('auth')->name('groups.store');
Route::get('/groups/{group}/edit', 'GroupController@edit')->middleware('auth')->name('groups.edit');
Route::patch('/groups/{group}', 'GroupController@update')->middleware('auth')->name('groups.update');

// overview pages
Route::get('/reservations/all', 'ReservationController@showAll')->name('all.index')->middleware('auth');
Route::get('/reservations/restaurant', 'ReservationController@showRestaurant')->name('restaurants.index')->middleware('auth');
Route::get('/reservations/group', 'GroupController@index')->name('groups.index')->middleware('auth');

// Resources
Route::post('/reservations/{id}/updateTable', 'ReservationController@updateTableNr')->name('updateTableNr');
Route::resource('/reservations', 'ReservationController')->middleware('auth');
Route::resource('/bowling', 'BowlingController')->middleware('auth');


