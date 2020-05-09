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

Route::middleware('guest:api')->group(function () {
    Route::post('auth/login', 'Auth\LoginController@login');
//    Route::patch('settings/profile', 'Settings\ProfileController@update');
//    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::middleware('auth:api')->group(function () {
    Route::get('auth/user', 'Auth\UserController@current');
    Route::post('auth/logout', 'Auth\LoginController@logout');

    Route::apiResources([
        'customer-types' => 'CustomerTypeController',
        'pool-records' => 'PoolRecordController',
    ]);

//    Route::post('register', 'Auth\RegisterController@register');
//    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
//    Route::post('email/resend', 'Auth\VerificationController@resend');
//    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
//    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');


});
