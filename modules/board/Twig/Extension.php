<?php namespace Board\Twig;

use Board\Markup\MarkupManager;
use Twig_Extension;

class Extension extends Twig_Extension {

    protected $markupManager;

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Board';
    }

    public function __construct()
    {
        $this->markupManager = MarkupManager::instance();
    }

}