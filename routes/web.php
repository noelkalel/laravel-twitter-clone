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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home',                          'TweetController@index')->name('tweets.index');
Route::post('/tweets',                       'TweetController@store')->name('tweets.store');
Route::delete('/tweets/{tweet}',             'TweetController@destroy')->name('tweets.destroy');

Route::post('/tweets/{tweet}/like',          'LikeController@store')->name('tweets.like.store');
Route::delete('/tweets/{tweet}/dislike',     'LikeController@destroy')->name('tweets.like.destroy');

Route::get('/profile/{user:name}',           'ProfileController@show')->name('profile.show');
Route::get('/profile/{user:name}/edit',      'ProfileController@edit')->name('profile.edit');
Route::patch('/profile/{user:name}',         'ProfileController@update')->name('profile.update');

Route::post('/profile/{user:name}/follow',   'FollowController@store')->name('follow.store');

Route::get('/explore-users',                 'ExploreController@index')->name('explore.index');


