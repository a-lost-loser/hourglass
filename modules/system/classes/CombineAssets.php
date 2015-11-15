<?php namespace System\Classes;

use Assetic\Filter\CssImportFilter;
use Assetic\Filter\CssRewriteFilter;
use Assetic\Filter\JSMinFilter;
use Assetic\Filter\LessCompiler;
use Train\Conductor\Support\Filters\JavascriptImporter;
use Train\Conductor\Support\Filters\StylesheetMinify;
use Train\Conductor\Support\Traits\Singleton;

class CombineAssets
{
    use Singleton;

    protected static $jsExtensions = ['js'];

    protected static $cssExtensions = ['css', 'less', 'scss', 'sass'];

    protected $aliases = [];

    protected $bundles = [];

    protected $filters = [];

    protected $localPath;

    protected $storagePath;

    public $useCache = false;

    public $useMinify = false;

    private static $callbacks = [];

    public function init()
    {
        $this->useCache = true;
        $this->useMinify = true;

        if ($this->useMinify === null) {
            $this->useMinify = false;
        }

        /*
         * Register Javascript filters
         */
        $this->registerFilter('js', new JavascriptImporter);

        /*
         * Register CSS filters
         */
        $this->registerFilter('css', new CssImportFilter);
        $this->registerFilter(['css', 'less'], new CssRewriteFilter);
        $this->registerFilter('less', new LessCompiler);

        /*
         * Optional minification filters
         */
        if ($this->useMinify) {
            $this->registerFilter('js', new JSMinFilter);
            $this->registerFilter(['css', 'less'], new StylesheetMinify);
        }

        /*
         * Deferred registration
         */
        foreach (static::$callbacks as $callback) {
            $callback($this);
        }
    }

    public function registerFilter($extension, $filter)
    {
        if (is_array($extension)) {
            foreach ($extension as $_extension) {
                $this->registerFilter($_extension, $filter);
            }
            return;
        }

        $extension = strtolower($extension);

        if (!isset($this->filters[$extension])) {
            $this->filters[$extension] = [];
        }

        if ($filter !== null) {
            $this->filters[$extension][] = $filter;
        }

        return $this;
    }
}
