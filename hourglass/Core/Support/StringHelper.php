<?php namespace Hourglass\Core\Support;

use Illuminate\Support\Str;

class StringHelper extends Str
{
    public static function normalizeClassName($name)
    {
        if (is_object($name))
            $name = get_class($name);

        $name = '\\'.ltrim($name, '\\');
        return $name;
    }
}