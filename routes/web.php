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

Route::resource('article', 'ArticleController');

Route::group(['prefix'=>'api/v1'], function() {
    Route::resource('article', 'ApiArticleController');
    Route::resource('user', 'ApiUserController');
    Route::get('mailcaptcha', 'ApiUserController@mailCaptcha');
    Route::post('login', 'ApiUserController@signin');
    Route::post('setavatar', 'ApiUserController@setavatar');
    Route::post('setcover', 'ApiUserController@setcover');
    Route::post('selfintro', 'ApiUserController@selfintro');
    Route::post('maininfo', 'ApiSetupController@maininfo');
    Route::get('loadtitles', 'ApiSetupController@loadTitles');
    Route::get('loadpositions', 'ApiSetupController@loadPositions');
    Route::get('loadcountries', 'ApiSetupController@loadCountries');
    Route::post('personalinfo', 'ApiSetupController@personalInfo');
    Route::post('aoginfo', 'ApiSetupController@aogInfo');
    Route::post('privacyinfo', 'ApiSetupController@privacyInfo');
    Route::get('acitivities', 'ApiArticleController@followingActivities');
    Route::get('articlecomments/{$articleid}/{$page}/{$lastid}', 'ApiArticleController@loadComments');


});
