<?php

/**
 * Register System routes before all user routes.
 */
App::before(function ($request) {
    Route::any('combine/{file}', 'System\Classes\Controller@combine');
});
