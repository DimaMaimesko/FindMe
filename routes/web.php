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
    Route::post('/home/get-users', 'HomeController@getUsers')->name('home.get.users');

    Route::get('/main', 'MainPageController@index')->name('main.index');
    Route::get('/chat', 'Chat\ChatController@index')->name('chat.index');
    Route::post('/chat/send', 'Chat\ChatController@sendMessage')->name('chat.send');
    Route::post('/chat/rooms/create', 'Chat\RoomsController@create')->name('chat.rooms.create');
    Route::post('/chat/rooms/create-room', 'Chat\RoomsController@createRoom')->name('chat.rooms.create.room');
    Route::put('/chat/rooms/update-room', 'Chat\RoomsController@updateRoom')->name('chat.rooms.update.room');
    Route::delete('/chat/rooms/delete-room', 'Chat\RoomsController@deleteRoom')->name('chat.rooms.delete.room');
    Route::get('/chat/rooms/get-rooms', 'Chat\RoomsController@getRooms')->name('chat.rooms.get');
    Route::get('/chat/rooms/get-members', 'Chat\RoomsController@getMembers')->name('chat.rooms.get-members');
    Route::get('/chat/rooms/get-friends', 'Chat\RoomsController@getFriends')->name('chat.rooms.get-friends');
    Route::get('/chat/rooms/get-members-friends', 'Chat\RoomsController@getMembersFriends')->name('chat.rooms.get-members-friends');

});


