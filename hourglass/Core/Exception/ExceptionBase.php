<?php namespace Hourglass\Core\Exception;

use File;
use Exception;

class ExceptionBase extends Exception
{
    protected $className;

    protected $errorType;


    public function __construct($message, $code, Exception $previous)
    {
        if ($this->className === null) {
            $this->className = get_called_class();
        }

        if ($this->errorType === null) {
            $this->errorType = 'Undefined';
        }

        parent::__construct($message, $code, $previous);
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getErrorType()
    {
        return $this->errorType;
    }

    public static function mask($message = null, $code = 0)
    {
        $calledClass = get_called_class();
        $exception = $calledClass($message, $code);
        ErrorHandler::applyMask($exception);
    }

    public static function umask()
    {
        ErrorHandler::removeMask();
    }

    public function setMask(Exception $exception)
    {
        $this->mask = $exception;
        $this->applyMask($exception);
    }

    public function applyMask(Exception $exception)
    {
        $this->file = $exception->getFile();
        $this->message = $exception->getMessage();
        $this->line = $exception->getLine();
        $this->className = get_class($exception);
    }
}