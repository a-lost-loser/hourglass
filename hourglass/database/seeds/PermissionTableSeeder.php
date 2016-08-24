<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Hourglass\Models\Permission([
            'name' => 'Hourglass.Backend::access.backend',
            'display_order' => '1',
        ]);
        $permission->save();
    }
}
