<?php

Route::group([
    'prefix'     => Config::get('forum.backend-prefix', 'backend'),
    'as'         => 'backend::',
    'middleware' => 'auth:backend-permission'
], function() {

    Route::get('/', function() {
        return view('Backend::main');
    });

});

Route::get('_assets/js', 'AssetController@javascript');
Route::get('_assets/css', 'AssetController@stylesheet');