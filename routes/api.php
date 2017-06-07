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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('hello', function()
{
    return response()->json([
        'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
    ]);
});

Route::post('user_info', 'Api\MemberController@getInfo');
Route::post('loginFacebook', ['as' => 'loginFacebook', 'uses' => 'Api\MemberController@loginFacebook']);
Route::post('loginGoogle', ['as' => 'loginGoogle', 'uses' => 'Api\MemberController@loginGoogle']);
Route::post('register', ['as' => 'register', 'uses' => 'Api\MemberController@register']);
Route::post('joinClass', ['as' => 'joinClass', 'uses' => 'Api\MemberController@joinClass']);

Route::post('getFullClass', ['as' => 'getFullClass', 'uses' => 'Api\ToeicClassesController@getFullClass']);
Route::post('getMembersOnline', ['as' => 'getMembersOnline', 'uses' => 'Api\ToeicClassesController@getMembersOnline']);
Route::post('beforeStart', ['as' => 'beforeStart', 'uses' => 'Api\ToeicClassesController@beforeStart']);
Route::post('previousLession', ['as' => 'previousLession', 'uses' => 'Api\ToeicClassesController@previousLession']);
Route::post('newWords', ['as' => 'newWords', 'uses' => 'Api\ToeicClassesController@newWords']);

Route::get('exercises', ['as' => 'exercises', 'uses' => 'Api\LessionController@exercises']);
Route::get('getResultsOfClass', ['as' => 'getResultsOfClass', 'uses' => 'Api\LessionController@getResultsOfClass']);
Route::post('submitAnswers', ['as' => 'submitAnswers', 'uses' => 'Api\LessionController@submitAnswers']);

Route::post('test', ['as' => 'test', 'uses' => 'Api\ExamController@getExamKit']);
Route::post('submitTest', ['as' => 'submitTest', 'uses' => 'Api\ExamController@submitTest']);