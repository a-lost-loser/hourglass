<?php namespace Hourglass\Addon;

class AddonConfiguration
{
    protected $composer = [];

    protected $yaml = [];

    public function __construct($composer, $yaml = [])
    {
        $this->composer = $composer;
        $this->yaml = $yaml;

        $this->normalize();
    }

    public function get($key, $default = null)
    {
        $parts = explode('.', $key);
        $parts = array_filter($parts);

        $element = ['composer' => $this->composer, 'yaml' => $this->yaml];
        foreach ($parts as $part) {
            if (!isset($element[$part])) {
                return $default;
            }

            $element = $element[$part];
        }

        return $element;
    }

    protected function set($key, $value)
    {
        $parts = explode('.', $key);
        $parts = array_filter($parts);

        $element = ['composer' => &$this->composer, 'yaml' => &$this->yaml];
        foreach ($parts as $part) {
            if (!isset($element[$part])) {
                throw new \Exception("Path does not exist in configuration.");
            }

            $element = &$element[$part];
        }

        $element = $value;
    }

    protected function normalize()
    {
        $name = str_replace('/', '-', $this->get('composer.name'));
        $this->set('composer.name', $name);
    }
}