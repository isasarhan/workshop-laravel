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
use App\User;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin', 'AdminController@index');
Route::get('astatus/{id}', 'AdminController@astatus')->name('astatus');
Route::get('approving', 'AdminController@approving')->name('approving');

Route::get('monitor/{id}', 'MonitorController@index')->name('monitor');
Route::get('show/{wid}/{mid}', 'MonitorController@show')->name('show');
Route::get('create/{id}', 'MonitorController@create')->name('create');
Route::post('store/{id}', 'MonitorController@store')->name('store');
Route::get('edit/{id}', 'MonitorController@edit')->name('edit');
Route::put('update/{id}', 'MonitorController@update')->name('update');
Route::delete('destroy/{id}', 'MonitorController@destroy')->name('destroy');
Route::get('mstatus/{id}', 'MonitorController@mstatus')->name('mstatus');
Route::get('stage/{id}', 'MonitorController@stage')->name('stage');
Route::get('switch/{wid}/{mid}', 'MonitorController@switch')->name('switch');

Route::get('createquestion/{wid}/{mid}', 'MonitorController@createquestion')->name('createquestion');
Route::post('storequestion/{wid}/{mid}', 'MonitorController@storequestion')->name('storequestion');
Route::delete('deletequestion/{wid}/{mid}', 'MonitorController@deletequestion')->name('deletequestion');
Route::get('sendquestion/{wid}/{mid}', 'MonitorController@sendquestion')->name('sendquestion');
Route::get('shuffleandsend/{wid}/{mid}', 'MonitorController@shuffleandsend')->name('shuffleandsend');
Route::get('chooseidea//{wid}/{mid}/{iid}', 'MonitorController@chooseidea')->name('chooseidea');

Route::get('storegroup/{wid}/{mid}', 'MonitorController@storegroup')->name('storegroup');
Route::get('showgroup/{gid}/{wid}/{mid}', 'MonitorController@showgroup')->name('showgroup');
Route::get('editgroup/{gid}/{wid}/{mid}', 'MonitorController@editgroup')->name('editgroup');
Route::put('updategroup/{gid}/{wid}/{mid}', 'MonitorController@updategroup')->name('updategroup');
Route::delete('destroygroup/{gid}/{wid}/{mid}', 'MonitorController@destroygroup')->name('destroygroup');
Route::get('destroyparticipant/{uid}/{gid}/{wid}/{mid}', 'MonitorController@destroyparticipant')->name('destroyparticipant');



Route::get('participant/{id}', 'ParticipantController@index')->name('participant');
Route::get('participant1/{id}', 'ParticipantController@index2')->name('participant1');
Route::get('messages', 'ParticipantController@messages')->name('messages');
Route::post('enter/{id}', 'ParticipantController@enter')->name('enter');
Route::get('createIdea/{wid}/{uid}', 'ParticipantController@createIdea')->name('createIdea');
Route::post('storeIdea/{wid}/{uid}', 'ParticipantController@storeIdea')->name('storeIdea');
Route::get('rateideas/{id}', 'ParticipantController@rateideas')->name('rateideas');
Route::post('storerate/{id}', 'ParticipantController@storerate')->name('storerate');
Route::get('availablegroups/{uid}/{wid}', 'ParticipantController@availablegroups')->name('availablegroups');//momkin zid parameter {wid}
Route::get('joingroup/{uid}/{gid}/{wid}', 'ParticipantController@joingroup')->name('joingroup');
Route::get('history/{uid}/{wid}', 'ParticipantController@history')->name('history');

