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

Route::get('questions', 'QuestionController@getAllQuestions')->name('question.all');

Route::group(['prefix' =>'question'], function() {
    Route::get('{id}', 'QuestionController@getQuestion')->name('question.get');

    Route::group(['middleware' => 'auth.basic.once'], function() {
        Route::post('', 'QuestionController@create')->name('question.create');
        Route::put('{id}', 'QuestionController@update')->name('question.update');
        Route::delete('{id}', 'QuestionController@delete')->name('question.delete');

        Route::post('{question_id}/file', 'FileController@createQuestionFile')->name('question.file.create');
        Route::delete('{question_id}/file/{file_id}', 'FileController@deleteQuestionFile')->name('question.file.delete');
    });
});

Route::group(['prefix' =>'question/{question_id}'], function() {
    Route::get('answer/{id}', 'AnswerController@get')->name('answer.get');

    Route::group(['middleware' => 'auth.basic.once'], function() {
        Route::post('answer', 'AnswerController@create')->name('answer.create');
        Route::put('answer/{id}', 'AnswerController@update')->name('answer.create');
        Route::delete('answer/{id}', 'AnswerController@delete')->name('answer.delete');

        Route::post('answer/{answer_id}/file', 'FileController@createAnswerFile')->name('answer.file.create');
        Route::delete('answer/{answer_id}/file/{file_id}', 'FileController@deleteAnswerFile')->name('answer.file.delete');
    });
});

// codedeploy test api
Route::get('test', 'TestController@test')->name('test');
