<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController as AnnController;

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


Route::get('announcemens', 'AnnController@index');

Route::get('announcementes/{id}', 'AnnController@show');

Route::post('announcements/{id}', 'AnnController@store');

Route::put('announcements/{id}', 'AnnController@update');

Route::delete('announcement/{id}', 'AnnController@delete');
