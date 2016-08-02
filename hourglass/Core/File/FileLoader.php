<?php namespace Hourglass\Core\File;

class FileLoader implements LoaderInterface
{
    protected $files;

    protected $defaultPath;

    protected $hints = [];

    protected $exists = [];

    public function __construct(Filesystem $files, $defaultPath)
    {
        $this->files = $files;
        $this->defaultPath = $defaultPath;
    }

    public function load($environment, $group, $namespace = null)
    {
        $items = [];

        $path = $this->getPath($namespace);

        if (is_null($path))
            return $items;

        $file = "{$path}/{$group}.php";

        if ($this->files->exists($file))
        {
            $items = $this->getRequire($file);
        }

        $file = "{$path}/{$environment}/{$group}.php";

        if ($this->files->exists($file))
        {
            $items = $this->mergeEnvironment($items, $file);
        }

        return $items;
    }

    public function exists($group, $namespace = null)
    {
        $key = $group.$namespace;

        if (isset($this->exists[$key]))
            return $this->exists[$key];

        $path = $this->getPath($namespace);

        if (is_null($path))
            return $this->exists[$key] = false;

        $file = "{$path}/{$group}.php";

        $exists = $this->files->exists($file);

        return $this->exists[$key] = $exists;
    }

    public function cascadePackage($environment, $package, $group, $items)
    {
        $path = $this->getPackagePath($package, $group);

        if ($this->files->exists($path)) {
            $items = array_merge($items, $this->getRequire($path));
        }

        $path = $this->getPackagePath($package, $group, $environment);

        if ($this->files->exists($path)) {
            $items = array_merge($items, $this->getRequire($path));
        }

        return $items;
    }

    public function getPackagePath($package, $group, $environment = null)
    {
        $package = strtolower(str_replace('.', '/', $package));

        if (!$environment) {
            $file = "{$package}/{$group}.php";
        } else {
            $file = "{$package}/{$environment}/{$group}.php";
        }

        return $this->defaultPath.'.'.$file;
    }

    public function getPath($namespace)
    {
        if (is_null($namespace))
            return $this->defaultPath;

        if (isset($this->hints[$namespace]))
            return $this->hints[$namespace];
    }

    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }

    protected function mergeEnvironment(array $items, $file)
    {
        return array_replace_recursive($items, $this->getRequire($file));
    }

    public function getNamespaces()
    {
        return $this->hints;
    }

    public function getRequire($path)
    {
        return $this->files->getRequire($path);
    }

    public function getFilesystem()
    {
        return $this->files;
    }
}