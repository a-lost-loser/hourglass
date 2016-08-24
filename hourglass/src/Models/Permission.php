<?php

namespace Hourglass\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $fillable = ['name', 'type', 'default_value', 'display_order', 'validate_pattern'];

    public $timestamps = false;

    public static function withName($name)
    {
        return self::where('name', $name)->first();
    }
}