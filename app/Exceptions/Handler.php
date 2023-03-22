<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (ModelNotFoundException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Item Not Found', ResponseAlias::HTTP_NOT_FOUND
                ]);
            }
        });

        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'unAuthenticated', ResponseAlias::HTTP_UNAUTHORIZED
                ]);
            }
        });

        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'UnprocessableEntity', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
                ]);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'The requested link does not exist', ResponseAlias::HTTP_BAD_REQUEST
                ]);
            }
        });

    }
}
