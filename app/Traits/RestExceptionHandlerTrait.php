<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

trait RestExceptionHandlerTrait
{
    /**
     * Render an exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderRestException(Request $request, Exception $e)
    {
        switch($e)
        {
            case ($e instanceof HttpResponseException):
                return response()->json($e->getResponse()->getContent(), $e->getResponse()->getStatusCode());

            case ($e instanceof ModelNotFoundException):
                return response()->json($e->getMessage(), 404);

            case ($e instanceof AuthenticationException):
                return response()->json('Unauthorized', 401);

            case ($e instanceof AuthorizationException):
                return response()->json($e->getMessage(), 403);

            default:
                return $this->convertExceptionToJsonResponse($e);
        }
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function convertExceptionToJsonResponse(Exception $e)
    {
        $e = FlattenException::create($e);

        return response()->json(\Arr::get(SymfonyResponse::$statusTexts, $e->getStatusCode()), $e->getStatusCode());
    }
}
