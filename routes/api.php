<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::group(['namespace' => 'Api\V1\User', 'prefix' => 'v1' , 'as' => 'api.'], function(){
	
	# LIST USERS AND FITER DATA (FROM JSON FILES)
	Route::get('users', 'ApiUserJsonController@fech_users')->name('users.fech_users');

	# LIST USERS AND FITER DATA (FROM DB)
	Route::get('db-users', 'ApiUserJsonController@fechAndFilterUsingDB')->name('users.fechAndFilterUsingDB');

	# READ DATA FROM JSON FILES AND INSERT THEM INTO DATABASE
	Route::get('read-insert/{file}', 'ApiUserJsonController@readJsonAndInsertDB')->name('users.readJsonAndInsertDB');

});

