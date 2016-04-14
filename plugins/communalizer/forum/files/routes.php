<?php

// See https://laravel.com/docs/5.1/routing for reference

Route::get('/', 'Communalizer\Forum\Controllers\Forum\ListForumsController@listAction');