<?php namespace Board\Twig;

use Illuminate\View\Engines\EngineInterface;
use Twig_Environment;

class Engine implements EngineInterface
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function get($path, array $vars = [])
    {
        $template = $this->environment->loadTemplate($path);
        return $template->render($vars);
    }
}