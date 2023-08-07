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


        Response::macro('cacheResponse', function ($data = [], $status_code = 200, $message = '', null|array $args = null,$ttl=60 * 60 * 2) {
            $array = [
                'data' => $data,
                'status_code' => $status_code,
                "message" => $message,
            ];
            $array = ($args == null) ? $array : array_merge($array, $args);

            return Cache::remember(request()->fullUrl(), $ttl, function () use ($array) {
                return response()->json($array);
            });
        });



        Response::macro('cacheResponsePaginate', function ($data = [], $status = 200, $message = '',$ttl=60 *60 * 2) {
            return Cache::remember(request()->fullUrl(), $ttl, function () use ($data, $status, $message) {
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
