<?php

namespace Hourglass\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function setIndividualPermission($permission, $value)
    {
        $object = is_string($permission) ? Permission::withName($permission) : $permission;

        if (!($object instanceof Permission)) {
            throw new \InvalidArgumentException('The argument has to be the name of an existing permission or the permission object.');
        }

        $this->individualPermissions()->save($object, ['value' => $value, 'assigned_type' => static::class]);

        return $this;
    }

    public function individualPermissions()
    {
        return $this
            ->belongsToMany(Permission::class, 'assigned_permissions', 'assigned_id')
            ->wherePivot('assigned_type', '=', static::class);
    }

    public function can($ability, $arguments = [])
    {
        foreach ($this->individualPermissions as $permission) {
            if ($permission->name == $ability) {
                return true;
            }
        }

        return parent::can($ability, $arguments);
    }
}