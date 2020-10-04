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

Route::group(['prefix' =>'user'], function() {
    Route::post('', 'UserController@create')->name('user.create');

    Route::group(['middleware' => 'auth.basic.once'], function() {
        Route::get('self', 'UserController@getSelf')->name('user.get');
        Route::put('self', 'UserController@updateSelf')->name('user.update');
    });

    Route::get('{id}', 'UserController@getUser')->name('user.details');
});

Route::group(['prefix' =>'question'], function() {
    Route::get('{id}', 'QuestionController@getQuestion')->name('user.get');

    Route::group(['middleware' => 'auth.basic.once'], function() {
        Route::post('', 'QuestionController@create')->name('question.create');
        Route::put('{id}', 'QuestionController@update')->name('question.update');
        Route::delete('{id}', 'QuestionController@delete')->name('question.delete');
    });
});
