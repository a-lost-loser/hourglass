<?php namespace Board\Twig;

use File;
use Twig_Error_Loader;
use Twig_LoaderInterface;

class Loader implements Twig_LoaderInterface
{
    protected $extension = 'htm';

    protected $cache = [];

    protected function findTemplate($name)
    {
        if (isset($this->cache[$name]))
            return $this->cache[$name];

        $finder = App::make('view')->getFinder();

        if (File::isFile($name)) {
            return $this->cache[$name] = $name;
        }

        $view = $name;
        if (File::extension($view) == $this->extension) {
            $view = substr($view, 0, -strlen($this->extension));
        }

        $path = $finder->find($view);
        return $this->cache[$name] = $path;
    }

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        return File::get($this->findTemplate($name));
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($name)
    {
        return $this->findTemplate($name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time Timestamp of the last modification time of the
     *                     cached template
     *
     * @return bool true if the template is fresh, false otherwise
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        return File::lastModified($this->findTemplate($name)) <= $time;
    }

    public function getFilename($name)
    {
        return $this->findTemplate($name);
    }

    public function exists($name)
    {
        try {
            $this->findTemplate($name);
            return true;
        }
        catch (Exception $exception) {
            return false;
        }
    }
}