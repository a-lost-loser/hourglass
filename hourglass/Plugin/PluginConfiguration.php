<?php namespace Hourglass\Plugin;

class PluginConfiguration
{
    protected $defaultConfiguration = [
        'base' => [
            'class'      => 'Plugin',
            'source-dir' => 'src/',
            'files-dir'  => 'files/',
        ],
    ];

    protected $raw = [];

    public function __construct(array $elements)
    {
        $this->raw = $elements;
    }

    public function get($key, $default = null)
    {
        $parts = explode('.', $key);

        $rawWithDefaults = array_replace_recursive($this->defaultConfiguration, $this->raw);
        $element = &$rawWithDefaults;

        $parts = array_filter($parts);

        foreach ($parts as $part) {
            if (!isset($element[$part])) {
                return $default;
            }

            $element = $element[$part];
        }

        return $element;
    }
}