<?php

Route::group(['prefix' => 'backend'], function() {

    // Authenticated Area
    Route::group(['middleware' => 'backend'], function() {

        Route::get('/', function() {
            return 'Hourglass';
        });

    });

    // Unauthenticated Area
    Route::get('login', function() {
        return 'Hourglass Login';
    });

});
