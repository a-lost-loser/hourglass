<?php

// See https://laravel.com/docs/5.1/routing for reference

Route::get('/', 'Exoplanet\Forum\Controllers\Forum\ListForumsController@listAction');