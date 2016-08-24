<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_permissions', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('assigned_id')->unsigned();
            $table->string('assigned_type');
            $table->mediumText('value');

            $table->primary(['permission_id', 'assigned_id', 'assigned_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assigned_permissions');
    }
}