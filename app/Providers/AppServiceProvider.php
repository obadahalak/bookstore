<?php

namespace App\Providers;

use App\Http\Resources\MetaDataResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

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

        Response::macro('data', function ($key = 'data', $data = [], array $args=null, $cache = false, $ttl = 60 * 60 * 2) {
            $response = [
                $key => $data,
            ];
           
            $response = ($args == null) ? $response : array_merge($response, $args);
            
            // if ($cache==true)
            //     return Cache::remember(request()->fullUrl(), $ttl, function () use ($response) {
            //         return $response;
            //     });
            return response()->json($response);
        });
        

        Response::macro('paginate', function ($data, $cache = false, $ttl = 60 * 60 * 2) {
            $response = Response::make([

                'data' => $data,
                'meta' => [
                    MetaDataResource::make($data)
                ],
            ]);

            // if ($cache==true)
            //     return Cache::remember(request()->fullUrl(), $ttl, function () use ($response) {
            //         return $response;
            //     });

            return $response;
        });

    }
}
