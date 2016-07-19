<?php

Route::group([
    'prefix'     => Config::get('forum.backend-prefix', 'backend'),
    'as'         => 'backend::',
    'middleware' => 'web',
], function() {

    Route::get('login', 'AuthController@showBackendLoginForm');
    Route::post('login', 'AuthController@backendLogin');

    // Authenticated section
    Route::group(['middleware' => 'auth.backend'], function() {

        Route::get('/', function() {
            return view('Backend::backend.main');
        });

    });

});

Route::get('_assets/js', 'AssetController@javascript');
Route::get('_assets/css', 'AssetController@stylesheet');