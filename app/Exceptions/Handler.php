<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if($this->isHttpException($exception)){
            switch ($exception->getStatusCode()) {
                // not found
                case 404:
                    return response()->json([
                        'message'   =>'Not found',
                        'code'      => (int) 404,
                    ], 404);
                // method not allowed
                case 405:
                    return response()->json([
                        'message'   =>'Method not allowed',
                        'code'      => (int) 405,
                    ], 405);

                // internal error
                case '500':
                    return response()->json([
                        'message'   =>'Internal error',
                        'code'      => (int) 500,
                    ], 500);

                default:
                    return $this->renderHttpException($exception);
                    break;
            }
        }else{
            return parent::render($request, $exception); 
        }
    }
}
