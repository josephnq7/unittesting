<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
//    Mail::raw('Hello World', function ($message) {
//        $message->to('joseph@bar.com');
//        $message->from('bar@foo.com');
//    });
//
//    return "Email was sent";
    return view('welcome');
});
