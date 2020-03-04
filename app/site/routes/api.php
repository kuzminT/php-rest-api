<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\AnnouncementController as AnnController;

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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', 'Auth\RegisterController@register');

Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout');


Route::get('announcementes', 'AnnouncementController@index');

Route::get('announcementes/{id}', 'AnnouncementController@show');

Route::post('announcements/{id}', 'AnnouncementController@store');

Route::put('announcements/{id}', 'AnnouncementController@update');

Route::delete('announcement/{id}', 'AnnouncementController@delete');
