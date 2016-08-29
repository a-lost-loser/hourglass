<?php

Route::group(['prefix' => 'backend', 'namespace' => 'Hourglass\Http\Controllers\Backend', 'middleware' => 'web'], function() {

    // Authenticated Area
    Route::group(['middleware' => 'backend'], function() {

        Route::get('/', function() {
            return 'Hourglass';
        });

    });

    // Unauthenticated Area
    Route::get('login', 'AuthorizationController@showLoginForm');
    Route::post('login', 'AuthorizationController@login');

});
