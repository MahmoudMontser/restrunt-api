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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');


    Route::get('place','API\PlaceController@index');
    Route::get('place/{id}','API\PlaceController@get_place');
    Route::post('place','API\PlaceController@create');
    Route::put('place','API\PlaceController@update');
    Route::delete('place/{id}','API\PlaceController@delete');


    Route::post('favourite','API\FavouriteController@add');
    Route::get('favourite','API\FavouriteController@my_favourites');
    Route::delete('favourite/{id}','API\FavouriteController@delete');




    Route::post('rate','API\RatingsController@rate');

    Route::post('search','API\SearchController@search');

});
