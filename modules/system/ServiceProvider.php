<?php namespace System;

use App;
use System\Twig\Engine as TwigEngine;
use System\Twig\Extension as TwigExtension;
use System\Twig\Loader as TwigLoader;
use Surgeon\Nurse\Module\ModuleServiceProvider;
use Surgeon\Nurse\Plugin\PluginManager;
use Twig_Environment;

class ServiceProvider extends ModuleServiceProvider
{
    public function register()
    {
        parent::register('system');

        PluginManager::instance()->registerAll();
    }

    public function boot()
    {
        PluginManager::instance()->bootAll();

        parent::boot('system');
    }

    protected function registerTwigParser()
    {
        App::singleton('twig.environment', function () {
            $twig = new Twig_Environment(new TwigLoader, ['auto_reload' => true]);
            $twig->addExtension(new TwigExtension);

            return $twig;
        });

        App::make('view')->addExtension('htm', 'twig', function () {
            return new TwigEngine(App::make('twig.environment'));
        });
    }
}