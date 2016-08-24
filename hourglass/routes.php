<?php

Route::group(['middleware' => 'backend', 'prefix' => 'backend'], function() {

    Route::get('/', function() {
        return 'Hourglass';
    });

    Route::get('login', function() {
        return 'Hourglass Login';
    });

});
