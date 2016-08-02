<?php namespace Hourglass\Core\Plugin;

use View;
use App;
use Composer\Autoload\ClassLoader;
use Config;
use File;
use Hourglass\Core\Parse\Yaml;
use Hourglass\Core\Support\Traits\Singleton;
use Hourglass\Core\Support\StringHelper;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class PluginManager
{
    use Singleton;

    protected $app;

    /**
     * @var PluginBase[]
     */
    protected $plugins;

    protected $pathMap = [];

    protected $registered = false;

    protected $booted = false;

    protected $metaFile;

    protected $disabledPlugins = [];

    protected $defaultBaseConfiguration = [
        'class'      => 'Plugin',
        'source-dir' => 'src/',
        'files-dir'  => 'files/',
    ];

    /**
     * @var ClassLoader
     */
    protected $loader;

    public static $noInit = false;

    protected function init()
    {
        $this->bindContainerObjects();
        $this->metaFile = storage_path() . '/board/disabled.json';
        //$this->loadDisabled();
        $this->loadPlugins();
        //$this->loadDependencies();

        $this->loader = new ClassLoader();
        $this->loader->register();
    }

    public function registerAll()
    {
        if ($this->registered)
            return;

        foreach ($this->plugins as $pluginId => $plugin) {
            $this->registerPlugin($plugin, $pluginId);
        }

        $this->registered = true;
    }

    public function bootAll()
    {
        if ($this->booted)
            return;

        foreach ($this->plugins as $plugin) {
            $this->bootPlugin($plugin);
        }

        $this->booted = true;
    }

    protected function registerAutoloading(Plugin $plugin)
    {
        $pluginPath = $this->getPluginPath($plugin);
        $sourcePath = $this->loadPluginBaseConfiguration($pluginPath)['source-dir'];
        $filesPath  = $this->loadPluginBaseConfiguration($pluginPath)['files-dir'];

        $this->loader->addClassMap([$pluginPath . '/' . $filesPath . 'migrations']);
        $this->loader->addPsr4($plugin->getNamespace(), $pluginPath . '/' . $sourcePath);
    }

    public function registerPlugin(Plugin $plugin, $pluginId = null)
    {
        if (!$pluginId)
            $pluginId = $this->getIdentifier($plugin);

        if (!$plugin || $plugin->disabled) {
            return;
        }

        $pluginPath = $this->getPluginPath($pluginId);
        $pluginNamespace = strtolower($pluginId);

        $this->registerAutoloading($plugin);

        if (!self::$noInit || $plugin->elevated) {
            App::register($plugin);
        }

        $filesPath = $this->loadPluginBaseConfiguration($pluginPath)['files-dir'];

        $langPath = "{$pluginPath}/{$filesPath}lang";
        if (File::isDirectory($langPath)) {
            Lang::addNamespace($pluginNamespace, $langPath);
        }

        $configPath = "{$pluginPath}/{$filesPath}config";
        if (File::isDirectory($langPath)) {
            Config::package($pluginNamespace, $configPath, $pluginNamespace);
        }

        $viewsPath = "{$pluginPath}/{$filesPath}views";
        if (File::isDirectory($viewsPath)) {
            View::addNamespace($plugin->getIdentifier(), $viewsPath);
        }

        $routesFile = "{$pluginPath}/{$filesPath}routes.php";
        if (File::exists($routesFile)) {
            require $routesFile;
        }
    }

    public function bootPlugin(Plugin $plugin)
    {
        if (!$plugin || $plugin->disabled)
            return;

        if (self::$noInit || $plugin->elevated) {
            $plugin->boot();
        }
    }

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

    public function loadPluginBaseConfiguration($path)
    {
        $config = (new Yaml)->parse(file_get_contents($path.'/plugin.yaml'));
        if (!isset($config['base']) || !is_array($config['base'])) {
            $config['base'] = [];
        }

        return array_merge($this->defaultBaseConfiguration, $config['base']);
    }

    public function loadPlugin($namespace, $path)
    {
        $pluginYaml = (new Yaml)->parse(file_get_contents($path.'/plugin.yaml'));
        $configuration = new PluginConfiguration($pluginYaml);

        $baseName = $configuration->get('base.class');

        $className = "$namespace\\$baseName";
        $classPath = "{$path}/{$configuration->get('base.source-dir')}{$baseName}.php";

        if (!class_exists($className)) {
            include_once $classPath;
        }

        if (!class_exists($className)) {
            // @TODO: Add logging when plugin doesn't load.
            return;
        }

        $classObject = new $className($this->app, $configuration);
        $classId = $this->getIdentifier($classObject);

        if ($this->isDisabled($classId)) {
            $classObject->disabled = true;
        }

        $this->plugins[$classId] = $classObject;
        $this->pathMap[$classId] = $path;

        return $classObject;
    }

    public function getIdentifier($namespace)
    {
        $namespace = StringHelper::normalizeClassName($namespace);
        if (strpos($namespace, '\\') === null) {
            return $namespace;
        }

        $parts = explode('\\', $namespace);
        $slice = array_slice($parts, 1, 2);
        $namespace = implode('.', $slice);

        return $namespace;
    }

    public function isDisabled($id)
    {
        $code = $this->getIdentifier($id);

        $disabled = array_key_exists($code, $this->disabledPlugins);
        return $disabled;
    }

    public function getPluginNamespaces()
    {
        $classNames = [];

        foreach ($this->getVendorAndPluginNames() as $vendorName => $vendorList) {
            foreach ($vendorList as $pluginName => $pluginPath) {
                $namespace = '\\'.$vendorName.'\\'.$pluginName;
                $namespace = StringHelper::normalizeClassName($namespace);
                $classNames[$namespace] = $pluginPath;
            }
        }

        return $classNames;
    }

    public function getPluginPath($id)
    {
        $classId = $this->getIdentifier($id);
        if (!isset($this->pathMap[$classId]))
            return null;

        return File::normalizePath($this->pathMap[$classId]);
    }

    public function getVendorAndPluginNames()
    {
        $plugins = [];

        $dirPath = plugins_path();
        if (!File::isDirectory($dirPath))
            return $plugins;

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirPath));
        $iterator->setMaxDepth(2);
        $iterator->rewind();

        while ($iterator->valid()) {
            if (($iterator->getDepth() > 1) && $iterator->isFile() && (strtolower($iterator->getFilename()) == "plugin.yaml")) {
                $filePath = dirname($iterator->getPathname());
                $pluginName = basename($filePath);
                $vendorName = basename(dirname($filePath));
                $plugins[$vendorName][$pluginName] = $filePath;
            }

            $iterator->next();
        }

        return $plugins;
    }

    public function getPluginList($returnObject = false)
    {
        $list = [];

        foreach ($this->plugins as $plugin)
        {
            $basePath   = $this->getPluginPath($plugin).'/';
            $config     = $this->loadPluginBaseConfiguration($basePath);
            $sourcePath = $basePath . $config['source-dir'];
            $filesPath  = $basePath . $config['files-dir'];

            $entry = [
                'identifier' => $plugin->getIdentifier(),
                'namespace'  => $plugin->getNamespace(),
                'paths'      => [
                    'base'   => $basePath,
                    'source' => $sourcePath,
                    'files'  => $filesPath,
                ],
                'assets'     => $plugin->getAssets(),
            ];

            if ($returnObject) $entry['object'] = $plugin;

            $list[] = $entry;
        }

        return $list;
    }
}