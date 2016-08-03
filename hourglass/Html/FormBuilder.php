<?php namespace Hourglass\Html;

use Illuminate\Contracts\Routing\UrlGenerator;

class FormBuilder
{
    protected $reserved = ['method', 'url', 'route', 'action', 'files', 'request', 'model', 'sessionKey'];

    protected $reservedAjax = ['request', 'success', 'error', 'complete', 'confirm', 'redirect', 'update', 'data'];

    protected $sessionKey;

    public function __construct(HtmlBuilder $html, UrlGenerator $url, $csrfToken, $sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }

    public function open(array $options = [])
    {
        $method = strtoupper(array_get($options, 'method', 'post'));
        $request = array_get($options, 'request');
        $model = array_get($options, 'model');

        if ($model)
            $this->model = $model;

        $append = $this->requestHandler($request);

        if ($method != 'GET')
            $append .= $this->sessionKey(array_get($options, 'session_key'));

        return "<form>";
    }

    protected function requestHandler($name = null)
    {
        return $name;
    }

    public function sessionKey($sessionKey = null)
    {
        return $sessionKey;
    }

    public function setSessionStore()
    {
        return $this;
    }
}