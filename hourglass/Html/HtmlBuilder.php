<?php namespace Hourglass\Html;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;

class HtmlBuilder
{
    public function __construct(UrlGenerator $url = null, Factory $view)
    {
        $this->url = $url;
        $this->view = $view;
    }
}