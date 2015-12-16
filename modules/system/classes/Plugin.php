<?php namespace System\Classes;


use Illuminate\Support\ServiceProvider;

class Plugin extends ServiceProvider
{
    /**
     * Determines whether the yaml configuration has been loaded or not.
     *
     * @var bool
     */
    protected $loadedYamlConfiguration = false;

    /**
     * The dependencies of this plugin.
     *
     * @var array
     */
    public $require = [];

    /**
     * Determines if this plugin should have elevated privileges.
     *
     * @var bool
     */
    public $elevated = false;

    /**
     * Determines if this plugin should be loaded or not.
     *
     * @var bool
     */
    public $disabled = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        $thisClass = get_class($this);
    }

    /**
     * Registers navigation menu items provided by this plugin.
     *
     * @return array
     */
    public function registerMenuItems()
    {
        return [];
    }

    /**
     * Registers backend navigation menu items provided by this plugin.
     *
     * @return array
     */
    public function registerBackendMenuItems()
    {
        return [];
    }
}