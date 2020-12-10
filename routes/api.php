<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', 'API\Auth\RegisterController@register')->name('api.register');
Route::post('login', 'API\Auth\LoginController@login')->name('api.login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', 'API\Auth\LoginController@logout')->name('api.logout');
    Route::get('current-available-colors','API\Transition\MainController@currentColors');
    Route::post('send','API\Transition\MainController@sendColor'); // member send their color
    
    Route::get('players','API\Transition\MainController@getPlayers');
    Route::get('today/matched','API\Transition\MainController@getTodayMatchedPlayers');
    Route::get('today/selected-color','API\Transition\MainController@selectedColor');
    Route::get('/positive-thinking','API\Transition\MainController@getPositiveThinking');
    Route::post('/done-positive','API\Transition\MainController@donePositiveThinking');
 
    Route::get('/users','API\Transition\MainController@getUsers');

    Route::post('/user/chat/detail','API\Transition\ChatController@userChatInfos');
    Route::post('/user/chat/send','API\Transition\ChatController@sendMessage');

    Route::post('/setting/change-password','API\Transition\SettingController@changePassword');
    Route::post('/setting/change-profile-pic','API\Transition\SettingController@changeProPic');

    Route::group([ 'middleware' => 'can:isAdmin' ], function(){
        Route::post('random/send','API\Transition\MainController@randomSendColor'); // admin send random and get result
    });
});
