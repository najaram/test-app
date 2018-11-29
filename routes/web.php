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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/photo/{id}/preview', 'PhotoPreviewController@preview')->name('photo.preview');


Route::middleware(['web', 'auth'])->group(function () {
    // Task
    Route::post('/tags', 'TagsController@store');

    // Photo
    Route::post('/photo', 'PhotosController@store');

    // Search
    Route::post('/search', 'PhotosSearchController@search');
});
