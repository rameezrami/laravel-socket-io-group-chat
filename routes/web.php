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

Route::get('/test', function(){
    $faker = Faker\Factory::create();
    $faker->uuid;
});
Route::get('/', 'ChatController@joinChat')->name('join');
Route::get('/chats', 'ChatController@viewChats')->name('chat');
Route::post('/send-chat', 'ChatController@sendChat')->name('send.chat');


