<?php namespace Hourglass\Parse;

use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class Yaml
{
    public function parse($contents)
    {
        $yaml = new Parser;
        return $yaml->parse($contents);
    }

    public function parseFile($fileName)
    {
        $contents = file_get_contents($fileName);
        return $this->parse($contents);
    }

    public function render($vars = [], $options = [])
    {
        extract(array_merge([
            'inline' => 20,
            'indent' => 0,
            'exceptionOnInvalidType' => false,
            'objectSupport' => true,
        ], $options));

        $yaml = new Dumper;
        return $yaml->dump($vars, $inline, $indent, $exceptionOnInvalidType, $objectSupport);
    }
}