<?php namespace Hourglass\Html;

use Hourglass\Addon\Addon;
use Hourglass\Support\Traits\Singleton;
use Illuminate\Contracts\View\Factory;

class TemplateResolver
{
    use Singleton;

    /**
     * @var array
     */
    protected $eventList = [];

    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @param Hourglass\Addon\Addon $plugin
     * @param string $event
     * @param string $view
     * @param int $priority
     */
    public function addEvent(Addon $addon, $event, $view, $priority = 100)
    {
        $view = $addon->getIdentifier() . '::' . $view;

        if (!isset($this->eventList[$event])) {
            $this->eventList[$event] = [];
        }

        $this->eventList[$event][] = ['priority' => $priority, 'view' => $view];
    }

    /**
     * @param string $event
     * @param Illuminate\Contracts\View\Factory $environment
     * @param array $variables
     * @return array
     */
    public function resolve($event, Factory $environment, array $variables)
    {
        if (!isset($this->eventList[$event])) {
            return '';
        }

        // Sort views by priority
        usort($this->eventList[$event], function($a, $b) {
            $priorityA = $a['priority'];
            $priorityB = $b['priority'];

            if ($priorityA == $priorityB)
                return 0;

            return $priorityA > $priorityB ? -1 : 1;
        });

        $result = '';
        foreach ($this->eventList[$event] as $view) {
            $result .= $environment->make($view['view'], $variables);
        }

        return $result;
    }

    public function addSection($section)
    {
        if (isset($this->sections[$section])) {
            return false;
        }

        $this->sections[$section] = [
            'enabled' => true,
        ];

        return true;
    }

    public function disableSection(Addon $addon, $section)
    {
        $this->sections[$section]['enabled']     = false;
        $this->sections[$section]['disabled-by'] = $addon->getIdentifier();
    }

    public function isSectionEnabled($section)
    {
        return isset($this->sections[$section]) && $this->sections[$section]['enabled'] == true;
    }
}