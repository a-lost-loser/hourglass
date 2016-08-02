<?php namespace Hourglass\Core\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;
use Config;
use DB;

class SetupMigrationRepository extends Migration
{
    public function up()
    {
        $pluginTable = Config::get('database.plugins');

        // Create plugins table
        Schema::create($pluginTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->index();
            $table->string('path');
            $table->string('version');
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

        // Add the Hourglass Backend as a plugin
        DB::table($pluginTable)->insert(
            [
                'id' => 0,
                'identifier' => 'Hourglass',
                'path' => base_path('modules/backend'),
                'version' => '0.1.0-pre-alpha',
                'is_enabled' => true,
                'created_at' => time(),
                'updated_at' => time(),
            ]
        );

        // Add the migrations table
        Schema::create(Config::get('database.migrations'), function (Blueprint $table) use ($pluginTable) {
            $table->string('migration');
            $table->integer('batch');
            $table->integer('plugin_id');

            // Foreign Key for plugins
            $table->foreign('plugin_id')->references('id')->on($pluginTable)->onDelete('restrict');
        });

        // Add the plugin dependencies table
        Schema::create('plugin_dependencies', function (Blueprint $table) use ($pluginTable) {
            $table->string('dependency');
            $table->integer('plugin_id');
            $table->string('version_constraint');

            // Foreign Key for plugins
            $table->foreign('plugin_id')->references('id')->on($pluginTable)->onDelete('restrict');
        });
    }

    public static function getTables()
    {
        return [
            Config::get('database.plugins'),
            Config::get('database.migrations'),
            'plugin_dependencies',
        ];
    }
}