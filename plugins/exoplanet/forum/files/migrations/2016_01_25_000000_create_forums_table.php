<?php

use Illuminate\Database\Schema\Blueprint;
use Exoplanet\Atmosphere\Database\Migrations\Migration;

class CreateForumsTable extends Migration
{

    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
        });
    }

    public function down()
    {
        Schema::drop('forums');

    }

}