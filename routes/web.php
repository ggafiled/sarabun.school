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

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::middleware(['auth'])->group( function () {

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('form/sending-add','DocumentController@sendingForm')->name('form.sending-add'); 

    Route::get('form/sending-search','DocumentController@sendingSearchForm');

    Route::get('form/receiving-add','DocumentController@receivingForm')->name('form.receiving-add'); 

    Route::get('form/receiving-search','DocumentController@receivingSearchForm'); 

    Route::get('form/command-add', function () {
        return view('command.command');
    }); 

    Route::get('form/command-search', function () {
        return view('command.command');
    }); 

    Route::get('form/memorandum-add', function () {
        return view('memorandum.memorandum');   
    }); 

    Route::get('form/memorandum-search', function () {
        return view('memorandum.memorandum');   
    }); 

    Route::get('form/editmypassword','HomeController@showChangePasswordForm')->middleware('password.confirm');

    Route::post('changePassword','HomeController@changePassword')->name('changePassword');

    Route::post('storeFileAndData','DocumentController@storeFileAndData');

    Route::post('deleteFileAndData/{documentid}', 'DocumentController@deleteFileAndData');

    Route::get('retrieveFile/{filename}','DocumentController@retrieveFile');
});