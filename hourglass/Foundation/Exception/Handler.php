<?php namespace Hourglass\Foundation\Exception;

use Log;
use Event;
use ReflectionFunction;
use Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use October\Rain\Exception\AjaxException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        Hourglass\Exception\AjaxException::class,
        Hourglass\Exception\ValidationException::class,
        Hourglass\Exception\ApplicationException::class,
        Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    protected $handlers = [];

    public function report(Exception $exception)
    {
        if ($this->shouldntReport($exception))
            return;

        Log::error($exception);
    }

    public function render($request, Exception $exception)
    {
        $statusCode = $this->getStatusCode($exception);
        $response = $this->callCustomHandlers($exception);

        if (!is_null($response)) {
            return Response::make($response, $statusCode);
        }

        if ($event = Event::fire('exception.beforeRender', [$exception, $statusCode, $request], true)) {
            return Response::make($event, $statusCode);
        }

        return parent::render($request, $exception);
    }

    protected function getStatusCode(Exception $exception)
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof AjaxException) {
            return 406;
        }

        return 500;
    }

    protected function callCustomHandlers(Exception $exception)
    {
        foreach ($this->handlers as $handler) {
            if ($this->handlesException($handler, $exception)) {

            }
        }
    }

    protected function handlesException(Closure $handler, Exception $exception)
    {
        $reflection = new ReflectionFunction($handler);
        return $reflection->getNumberOfParameters() == 0 || $this->hints($reflection, $exception);
    }

    protected function hints(ReflectionFunction $reflection, Exception $exception)
    {
        $parameters = $reflection->getParameters();
        $expected = $parameters[0];
        return !$expected->getClass() || $expected->getClass()->isInstance($exception);
    }

    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        if (view()->exists("Backend::errors.{$status}")) {
            return response()->view("Backend::errors.{$status}", ['exception' => FlattenException::create($e)], $status);
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }

    protected function convertExceptionToResponse(Exception $e)
    {
        return response()->view("Backend::errors.generic", ['exception' => FlattenException::create($e)], 501);
    }
}