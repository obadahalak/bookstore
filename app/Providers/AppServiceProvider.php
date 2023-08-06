<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {



        Model::preventLazyLoading();

        Response::macro('data', function ($data = [], $status_code = 200, $message = '') {
            return response()->json([
                'data' => $data,
                'status_code' => $status_code,
                "message" => $message,
            ]);
        });

        Response::macro('paginate', function ($data) {

            return Response::make([
                'data' => $data->items(),
                'meta' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ]
            ]);
        });


        Response::macro('cacheResponse', function ($data = [], $status_code = 200, $message = '', $args) {
            
            return Cache::remember(request()->fullUrl(), 60 * 2, function () use ($data, $status_code, $message,$args) {
                return response()->json([
                    'data' => $data,
                        ...$args,
                    'status_code' => $status_code,
                    "message" => $message,
                ]);
            });

        });


        
        Response::macro('cacheResponsePaginate', function ($data = [], $status = 200, $message = '') {
            return Cache::remember(request()->fullUrl(), 60 * 2, function () use ($data, $status, $message) {
                return Response::make([
                    'data' => $data->items(),
                    'meta' => [
                        'current_page' => $data->currentPage(),
                        'last_page' => $data->lastPage(),
                        'per_page' => $data->perPage(),
                        'total' => $data->total(),
                    ]
                   
                ]);
            });

        });
    }
}