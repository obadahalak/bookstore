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

        Response::macro('data', function (string $key, array $data, ?array $args = null, bool $cache = false, int $ttl = 7200) {
            $response = [
                $key => $data,
            ];
        
            if ($args !== null) {
                $response = array_merge($response, $args);
            }
        
            if ($cache) {
                return Cache::remember(request()->fullUrl(), $ttl, function () use ($response) {
                    return response()->json($response);
                });
            }
        
            return response()->json($response);
        });
      

        Response::macro('paginate', function ($paginatedData, bool $cache = false, int $ttl = 7200): Response {
            $response = Response::make([
                'data' => $paginatedData,
                'meta' => [
                    MetaDataResource::make($paginatedData)
                ],
            ]);
        
            if ($cache) {
                return Cache::remember(request()->fullUrl(), $ttl, function () use ($response) {
                    return $response;
                });
            }
        
            return $response;
        });

    }
}
