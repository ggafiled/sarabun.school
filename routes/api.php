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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sendingcontent', 'API\DocumentTableController@sending');

Route::get('receivingcontent', 'API\DocumentTableController@receiving');

Route::get('commandcontent', 'API\DocumentTableController@command');

Route::get('memorandumcontent', 'API\DocumentTableController@memorandum');

Route::get('usercontent', 'API\DocumentTableController@usercontent');

Route::post('getSendingLastId', 'API\DocumentTableController@getSendingLastId');

Route::post('getReceivingLastId', 'API\DocumentTableController@getReceivingLastId');

Route::post('getCommandLastId', 'API\DocumentTableController@getCommandLastId');

Route::post('getMemorandumLastId', 'API\DocumentTableController@getMemorandumLastId');