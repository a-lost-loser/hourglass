<?php namespace Hourglass\Core\Foundation;

use Closure;
use Illuminate\Foundation\Application as ApplicationBase;
use \Symfony\Component\Debug\Exception\FatalErrorException;

class Application extends ApplicationBase {
    protected $pluginsPath;

    protected $themesPath;

    protected $executionContext;

    public function publicPath()
    {
        return $this->basePath();
    }

    public function langPath()
    {
        return $this->basePath.'/lang';
    }

    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();

        foreach (['plugins', 'themes', 'temp'] as $path) {
            $this->instance('path.'.$path, $this->{$path."Path"}());
        }
    }

    public function pluginsPath()
    {
        return $this->pluginsPath ?: $this->basePath.'/plugins';
    }

    public function setPluginsPath($path)
    {
        $this->pluginsPath = $path;
        $this->instance('path.plugins', $path);
        return $this;
    }

    public function themesPath()
    {
        return $this->themesPath ?: $this->basePath.'/themes';
    }

    public function setThemesPath($path)
    {
        $this->themesPath = $path;
        $this->instance('path.themes', $path);
        return $this;
    }

    public function tempPath()
    {
        return $this->basePath.'/storage/temp';
    }

    public function before($callback)
    {
        return $this['router']->before($callback);
    }

    public function after($callback)
    {
        return $this['router']->after($callback);
    }

    public function error(Closure $callback)
    {
        $this->make('Illuminate\Contracts\Debug\ExceptionHandler')->error($callback);
    }

    public function fatal(Closure $callback)
    {
        $this->error(function(FatalErrorException $e) use ($callback) {
            return call_user_func($callback, $e);
        });
    }

    public function runningInBackend()
    {
        return $this->executionContext == "backend";
    }

    public function setExecutionContext($context)
    {
        $this->executionContext = $context;
    }

    // TODO: Caching
}