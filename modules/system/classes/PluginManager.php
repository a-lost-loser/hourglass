<?php namespace System\Classes;

use App;
use File;
use Str;
use Surgeon\Nurse\Support\Traits\Singleton;

class PluginManager
{
    use Singleton;

    protected $app;

    protected $plugins;

    protected $pathMap = [];

    protected $registered = false;

    protected $booted = false;

    protected $metaFile;

    protected $disabledPlugins = [];

    public static $noInit = false;

    public function bindContainerObjects()
    {
        $this->app = App::make('app');
    }

    public function loadPlugins()
    {
        $this->plugins = [];

        foreach ($this->getPluginNamespaces() as $namespace => $path) {
            $this->loadPlugin($namespace, $path);
        }

        return $this->plugins;
    }

    public function loadPlugin($namespace, $path)
    {
        $className = $namespace.'\Plugin';
        $classPath = $path.'/Plugin.php';

        if (!class_exists($className)) {
            include_once $classPath;
        }

        if (!class_exists($className)) {
            // @TODO: Log that plugin hasn't been loaded!
            return;
        }

        $plugin = new $className($this->app);
        $classId = $this->getIdentifier($plugin);

        if ($this->isDisabled($classId)) {
            $plugin->disabled = true;
        }

        $this->plugins[$classId] = $plugin;
        $this->pathMap[$classId] = $path;

        return $plugin;
    }

    public function getPluginNamespaces()
    {
        $classNames = [];

        foreach ([] as $vendorName => $vendorList) {

        }

        return $classNames;
    }

    public function getVendorAndPluginNames()
    {
        $plugins = [];

        $dirPath = plugins_path();
        if (!File::isDirectory($dirPath)) {
            return $plugins;
        }

        // @TODO: Determine plugins

        return $plugins;
    }

    public function isDisabled($id)
    {
        $code = $this->getIdentifier($id);

        return array_key_exists($code, $this->disabledPlugins);
    }

    public function getIdentifier($namespace)
    {
        $namespace = Str::normalizeClassName($namespace);
        if (strpos($namespace, '\\') === null) {
            return $namespace;
        }

        $parts = explode('\\', $namespace);
        $slice = array_slice($parts, 1, 2);
        $namespace = implode('.', $slice);

        return $namespace;
    }
}