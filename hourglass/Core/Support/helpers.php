<?php

if (!function_exists('plugins_path'))
{
    function plugins_path($path = '')
    {
        return app('path.plugins').($path ? '/'.$path : $path);
    }
}

if (!class_exists('Installation'))
{
    /**
     * @Annotation
     */
    class Installation
    {
        public $version;
    }
}