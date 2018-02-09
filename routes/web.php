<?php

// Route::group(['middleware' => 'guest'], function () {
//     Route::get('/', 'CustomAuthController@showLoginPage')->name('show.login');
//     Route::post('login', 'CustomAuthController@doLogin')->name('do.login');
//     Route::get('register', 'CustomAuthController@showRegistrationPage')->name('show.registration');
//     Route::post('register', 'CustomAuthController@doRegister')->name('do.register');
// });

// Route::group(['middleware' => 'auth'], function () {
Route::get('/', 'HomeController@index')->name('home');

Route::resource('farms', 'FarmsController');

Route::group(['prefix' => 'farms/{farm}'], function () {
    Route::resource('buildings', 'BuildingsController')->only(['index', 'store', 'update', 'destroy']);
});

Route::group(['prefix' => 'buildings/{building}'], function () {
    Route::resource('decks', 'DecksController')->only(['index', 'store', 'update', 'destroy']);
});

Route::group(['prefix' => 'decks/{deck}'], function () {
    Route::resource('columns', 'ColumnsController')->only(['index', 'store', 'update', 'destroy']);
});

Route::resource('grows', 'GrowsController');
Route::group(['prefix' => 'grows/{grow}/chick-in', 'as' => 'grows.chick-in.'], function () {
    Route::get('/', 'GrowChickInController@index')->name('index');
    Route::post('/', 'GrowChickInController@update')->name('update');
});
Route::group(['prefix' => 'grows/{grow}/daily-logs', 'as' => 'grows.daily-logs.'], function () {
    Route::get('/', 'DailyLogsController@index')->name('index');
    Route::post('/', 'DailyLogsController@store')->name('store');
    Route::get('create', 'DailyLogsController@create')->name('create');
    Route::get('{dailyLog}/edit', 'DailyLogsController@edit')->name('edit');
    Route::patch('{dailyLog}', 'DailyLogsController@update')->name('update');
});

Route::group(['prefix' => 'grows/{grow}/harvest', 'as' => 'grows.harvests.'], function () {
    Route::get('/', 'HarvestController@index')->name('index');
    Route::post('/', 'HarvestController@store')->name('store');
    Route::get('create', 'HarvestController@create')->name('create');
    Route::get('{harvest}/edit', 'HarvestController@edit')->name('edit');
    Route::patch('{harvest}', 'HarvestController@update')->name('update');

});

Route::resource('feeds', 'FeedsController');
// });
