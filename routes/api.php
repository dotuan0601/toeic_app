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

Route::get('user_info', 'Api\MemberController@getInfo');
Route::post('loginFacebook', ['as' => 'loginFacebook', 'uses' => 'Api\MemberController@loginFacebook']);
Route::post('loginGoogle', ['as' => 'loginGoogle', 'uses' => 'Api\MemberController@loginGoogle']);
Route::post('register', ['as' => 'register', 'uses' => 'Api\MemberController@register']);

Route::get('getFullClass', ['as' => 'getFullClass', 'uses' => 'Api\ToeicClassesController@getFullClass']);
Route::get('getMembersOnline', ['as' => 'getMembersOnline', 'uses' => 'Api\ToeicClassesController@getMembersOnline']);