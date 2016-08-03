<?php namespace Hourglass\Addon;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class Addon extends ServiceProvider
{
    protected $configuration;

    /**
     * PluginBase constructor.
     * @param Application $app
     * @param AddonConfiguration $configuration
     */
    public function __construct(Application $app, AddonConfiguration $configuration)
    {
        parent::__construct($app);

        $this->configuration = $configuration;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->includeViews();
        $this->includeRoutes();
    }

    /**
     * Includes optional routes for the addon.
     *
     * @return void
     */
    protected final function includeRoutes()
    {
    }

    /**
     * Includes optional views for the addon.
     *
     * @return void
     */
    protected final function includeViews()
    {
    }

    protected function routes()
    {
        // Do nothing
    }

    protected function getPath($suffix)
    {
        return base_path('addons/' . $this->configuration->get('composer.name') . '/' . $suffix);
    }

    public function getIdentifier()
    {
        return $this->configuration->get('composer.name');
    }
}