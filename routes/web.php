<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect('/home');
});

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

// Logs view 
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// Home page view 
Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::middleware(['auth'])->group( function () {

    Route::get('form/sending-add','DocumentController@sendingForm')->name('form.sending-add'); 

    Route::get('form/sending-search','DocumentController@sendingSearchForm');

    Route::get('form/receiving-add','DocumentController@receivingForm')->name('form.receiving-add'); 

    Route::get('form/receiving-search','DocumentController@receivingSearchForm'); 

    Route::get('form/usermanagement','AdminController@usermanagementForm')->name('form.usermanagementForm'); 

    Route::get('form/command-add','DocumentController@commandForm')->name('form.command-add'); ; 

    Route::get('form/command-search','DocumentController@commandSearchForm'); 

    Route::get('form/memorandum-add','DocumentController@memorandumForm')->name('form.memorandum-add'); ; 

    Route::get('form/memorandum-search','DocumentController@memorandumSearchForm'); 

    Route::get('form/editmypassword','HomeController@showChangePasswordForm')->middleware('password.confirm');
    

    Route::post('changePassword','HomeController@changePassword')->name('changePassword');

    Route::post('storeFileAndData','DocumentController@storeFileAndData');

    Route::post('deleteFile/{fileid}','DocumentController@deleteFile');

    Route::post('renameFile', 'DocumentController@renameFile');

    Route::post('deleteFileAndData/{documentid}', 'DocumentController@deleteFileAndData');

    Route::get('retrieveFile/{filename}','DocumentController@retrieveFile');
});