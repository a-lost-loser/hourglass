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
