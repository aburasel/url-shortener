<?php

namespace App\Exceptions;

use App\Http\Traits\ResponseAPI;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseAPI;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof NotFoundHttpException) {
                    return $this->error('Not found', Response::HTTP_NOT_FOUND);
                }if ($e instanceof AuthenticationException) {
                    return $this->error($e->getMessage() . get_class($e), Response::HTTP_UNAUTHORIZED);
                } else {
                    return $this->error($e->getMessage() . get_class($e), Response::HTTP_BAD_REQUEST);
                }

            }
        });
    }

}
