<?php namespace Hourglass\Addon;

use Hourglass\Addon\Facades\Addons;

class AddonFileProvider
{
    public static function compiles()
    {
        $addons = Addons::all();

        // Build a file list for all addons
        return [

        ];
    }
}