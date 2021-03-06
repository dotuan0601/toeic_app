<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/', 'HomeController@index');


Route::resource('level', 'LevelController');

Route::resource('test', 'TestController');
Route::get('/test/exam/{id}', 'TestController@exam');
Route::get('/test/exercise/{id}', 'TestController@exercise');
Route::get('/test/list_by_exam/{exam_id}', 'TestController@list_by_exam');
Route::get('/test/list_by_exercise/{exercise_id}', 'TestController@list_by_exercise');
Route::get('/test/edit_by_exam/{id}/{exam_id}', 'TestController@edit_by_exam');
Route::get('/test/edit_by_exercise/{id}/{exercise_id}', 'TestController@edit_by_exercise');
Route::get('/test/destroy_by_exam/{id}/{exam_id}', 'TestController@destroy_by_exam');
Route::get('/test/destroy_by_exercise/{id}/{exercise_id}', 'TestController@destroy_by_exercise');

Route::resource('question', 'TestController');

Route::resource('exercise', 'ExerciseController');
Route::get('exercise/create_for_lession/{lession_id}', 'ExerciseController@create_for_lession');
Route::get('exercise/remove/{lession_id}', 'ExerciseController@remove');

Route::resource('new_words', 'NewWordsController');
Route::get('new_words/create_for_lession/{lession_id}', 'NewWordsController@create_for_lession');
Route::get('/new_words/remove/{id}', 'NewWordsController@remove');

Route::resource('lession', 'LessionController');

Route::resource('exam_kit', 'ExamKitController');

Route::resource('exam', 'ExamController');
Route::get('/exam/listening/{kitid}', 'ExamController@listening');
Route::get('/exam/reading/{kitid}', 'ExamController@reading');
Route::get('/exam/remove/{id}', 'ExamController@remove');
