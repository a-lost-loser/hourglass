<?php namespace Hourglass\Exception;

class AjaxException extends ExceptionBase
{
    protected $contents;

    public function __construct($contents)
    {
        if (is_string($contents)) {
            $contents = ['results' => $contents];
        }

        $this->contents = $contents;

        parent::__construct(json_encode($contents));
    }

    public function getContents()
    {
        return $this->contents;
    }
}