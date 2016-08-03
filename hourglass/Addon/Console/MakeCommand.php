<?php namespace Hourglass\Addon\Console;

use Illuminate\Console\Command;

class MakeCommand extends Command
{
    protected $name = 'make:addon';

    protected $options = [];

    public function handle()
    {
        $this->gatherInput();
    }

    protected function gatherInput()
    {
        $this->options['author.name'] = $this->ask('What is the developers name?');
        $this->options['author.mail'] = $this->ask('What is the developers mail address?');
        $this->options['name'] = $this->ask('What is the addon called?');
        $this->options['version'] = $this->ask('What version is your addon?', '1.0');

        return $this;
    }
}