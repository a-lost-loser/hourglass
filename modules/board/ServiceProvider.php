<?php namespace Board;

use App;
use Board\Twig\Engine as TwigEngine;
use Board\Twig\Extension as TwigExtension;
use Board\Twig\Loader as TwigLoader;
use Surgeon\Nurse\Module\ModuleServiceProvider;
use Surgeon\Nurse\Plugin\PluginManager;
use Twig_Environment;

class ServiceProvider extends ModuleServiceProvider
{
    public function register()
    {
        parent::register('board');

        PluginManager::instance()->registerAll();
    }

    public function boot()
    {
        PluginManager::instance()->bootAll();

        parent::boot('board');
    }

    protected function registerTwigParser()
    {
        App::singleton('twig.environment', function ($app) {
            $twig = new Twig_Environment(new TwigLoader, ['auto_reload' => true]);
            $twig->addExtension(new TwigExtension);

            return $twig;
        });

        App::make('view')->addExtension('htm', 'twig', function () {
            return new TwigEngine(App::make('twig.environment'));
        });
    }
}