<?php

namespace App\Exceptions;

use Throwable;
use function PHPUnit\Framework\matches;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e)
    {
      
        if($e instanceof ModelNotFoundException){

            $model=match($e->getModel()){
                'App\\Models\\User' =>'User',
                default=>'record'
            };
            return response()->json(['error'=>"$model not found"]);
        }
        if($e instanceof NotFoundHttpException){
            $message=$e->getMessage();
            return response()->json(['error'=>"$message "]);
        }
        parent::render($request,$e);
    }
}
