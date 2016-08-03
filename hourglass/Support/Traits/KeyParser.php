<?php namespace Hourglass\Support\Traits;

trait KeyParser
{
    protected $keyParserCache = [];

    public function setParsedKey($key, $parsed)
    {
        $this->keyParserCache[$key] = $parsed;
    }

    public function parseKey($key)
    {
        if (isset($this->keyParserCache[$key]))
            return $this->keyParserCache[$key];

        $segments = explode('.', $key);

        if (strpos($key, '::') === false) {
            $parsed = $this->keyParserParseBasicSegments($segments);
        } else {
            $parsed = $this->keyParserParseSegments($key);
        }

        return $this->keyParserCache[$key] = $parsed;
    }

    protected function keyParserParseBasicSegments(array $segments)
    {
        $group = $segments[0];

        if (count($segments) == 1)
            return [null, $group, null];

        $item = implode('.', array_slice($segments, 1));

        return [null, $group, $item];
    }

    protected function keyParserParseSegments($key)
    {
        list($namespace, $item) = explode('::', $key);

        $itemSegments = explode('.', $item);

        $groupAndItem = array_slice($this->keyParserParseBasicSegments($itemSegments), 1);

        return array_merge([$namespace], $groupAndItem);
    }
}