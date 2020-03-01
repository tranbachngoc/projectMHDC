<?php

use App\Http\Middleware\RedirectIfAuthenticated;

/**
 * Admin panel
 * TODO - add authorization for admin user here
 * TODO - add role here
 */
Route::group(['prefix' => 'backend', 'namespace' => 'Backend'], function () {
    Route::get('login', 'AuthController@login');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    Route::group(['middleware' => RedirectIfAuthenticated::class . ':admin'], function () {
        Route::get('dashboard', 'DashboardController@index');
        
        Route::get('achievements/demo/view', 'AchievementController@demoView');
        Route::get('achievements/demo/start', 'AchievementController@demoStart');

        Route::get('settings', 'SettingController@index');
        Route::get('settings/{id}/update', 'SettingController@update');
        Route::put('settings/{id}/update', 'SettingController@update');
    });
});
