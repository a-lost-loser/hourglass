<?php namespace Hourglass\Config;

use ArrayAccess;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Hourglass\File\LoaderInterface;
use Hourglass\Support\Traits\KeyParser;

class Repository implements ArrayAccess, ConfigContract
{
    use KeyParser;

    protected $loader;

    protected $environment;

    protected $items = [];

    protected $packages = [];

    protected $afterLoad = [];

    public function __construct(LoaderInterface $loader, $environment)
    {
        $this->loader = $loader;
        $this->environment = $environment;
    }

    public function load($group, $namespace, $collection)
    {
        $env = $this->environment;

        if (isset($this->items[$collection])) {
            return;
        }

        $items = $this->loader->load($env, $group, $namespace);

        if (isset($this->afterLoad[$namespace])) {
            $items = $this->callAfterLoad($namespace, $group, $items);
        }

        $this->items[$collection] = $items;
    }

    public function callAfterLoad($namespace, $group, $items)
    {
        $callback = $this->afterLoad[$namespace];

        return call_user_func($callback, $this, $group, $items);
    }

    public function parseConfigKey($key)
    {
        if (strpos($key, '::') === false)
            return $this->parseKey($key);

        if (isset($this->keyParserCache[$key]))
            return $this->keyParserCache[$key];

        $parsed = $this->parseNamespaceSegments($key);
        return $this->keyParserCache[$key] = $parsed;
    }

    protected function parseNamespaceSegments($key)
    {
        list ($namespace, $item) = explode('::', $key);

        if (in_array($namespace, $this->packages))
            return $this->parsePackageSegments($key, $namespace, $item);

        return $this->keyParserParseSegments($key);
    }

    protected function parsePackageSegments($key, $namespace, $item)
    {
        $itemSegments = explode('.', $item);

        if (!$this->loader->exists($itemSegments[0], $namespace))
            return [$namespace, 'config', $item];

        return $this->keyParserParseSegments($key);
    }

    public function package($namespace, $hint)
    {
        $this->packages[] = $namespace;

        $this->addNamespace($namespace, $hint);

        $this->afterLoading($namespace, function($me, $group, $items) use ($namespace) {
            $env = $me->getEnvironment();

            $loader = $me->getLoader();

            return $loader->cascadePackage($env, $namespace, $group, $items);
        });
    }

    public function getCollection($group, $namespace = null)
    {
        $namespace = $namespace ?: '*';

        return $namespace.'::'.$group;
    }

    public function addNamespace($namespace, $hint)
    {
        $this->loader->addNamespace($namespace, $hint);
    }

    public function afterLoading($namespace, Closure $callback)
    {
        $this->afterLoad[$namespace] = $callback;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    public function has($key)
    {
        $default = microtime(true);

        return $this->get($key, $default) !== $default;
    }

    public function get($key, $default = null)
    {
        list($namespace, $group, $item) = $this->parseConfigKey($key);

        $collection = $this->getCollection($group, $namespace);

        $this->load($group, $namespace, $collection);

        return array_get($this->items[$collection], $item, $default);
    }

    public function set($key, $value = null)
    {
        list($namespace, $group, $item) = $this->parseConfigKey($key);

        $collection = $this->getCollection($group, $namespace);

        $this->load($group, $namespace, $collection);

        if (is_null($item)) {
            $this->items[$collection] = $value;
        } else {
            array_set($this->items[$collection], $item, $value);
        }
    }

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->set($key, null);
    }

    public function all()
    {
        return $this->items;
    }

    public function prepend($key, $value)
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    public function push($key, $value)
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }
}