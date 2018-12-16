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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('users', 'UsersController');

});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'frontend',
    'as' => 'frontend.',
    'namespace' => 'Frontend',
], function () {

    Route::get('/home', 'HomeController@index')->name('home.index');
    Route::post('/home/follow', 'HomeController@follow')->name('home.follow');
    Route::post('/home/unfollow', 'HomeController@unfollow')->name('home.unfollow');

    Route::get('/main', 'MainPageController@index')->name('main.index');
    Route::get('/chat', 'Chat\ChatController@index')->name('chat.index');
    Route::post('/chat/send', 'Chat\ChatController@sendMessage')->name('chat.send');

});


