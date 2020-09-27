<?php

namespace App\Exceptions;

use Exception;
use App\Traits\RestTrait;
use App\Traits\RestExceptionHandlerTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as BaseValidationException;

class Handler extends ExceptionHandler
{
    use RestTrait, RestExceptionHandlerTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        
        BadRequestException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            //
        }
        
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isApiCall($request) || $this->isAjaxCall($request)) {
            return $this->renderForRest($request, $exception);
        }
        
        return $this->renderForWeb($request, $exception);
    }

    /**
     * Render an exception into an HTTP response for a RESTful request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return Illuminate\Http\JsonResponse
     */
    protected function renderForRest($request, $e)
    {
        switch ($e)
        {
            case ($e instanceof ModelNotFoundException):
                return response()->json($e->getMessage(), 404);

            case ($e instanceof BaseValidationException):
                return response()->json($e->errors()->toArray(), 400);

            case ($e instanceof BadRequestException):
                return response()->json($e->getMessage(), 400);

            case ($e instanceof InvalidCredentialsException):
                return response()->json($e->getMessage(), 400);

            default:
                return $this->renderRestException($request, $e);
        }
    }

    /**
     * @param $request
     * @param Exception $e
     * @return $this|\Symfony\Component\HttpFoundation\Response
     */
    protected function renderForWeb($request, Exception $e)
    {
        return parent::render($request, $e);
    }
}
