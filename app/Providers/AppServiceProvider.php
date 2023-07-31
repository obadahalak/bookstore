<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
    public function boot(){
    

        
    Model::preventLazyLoading();
    
        Response::macro('data', function ( $data=[],$status=200,$message='') {
            return response()->json([
                'data'=>$data,
                'status'=>$status,    
                "message"=>$message,              
            ]);
        });

        Response::macro('paginate', function ($data) {
    
        return Response::make([
            'data'=>$data->items(),
            'meta'=>[
                'current_page'=>$data->currentPage(),
                'last_page'=>$data->lastPage(),
                'per_page'=>$data->perPage(),
                'total'=>$data->total(),
            ]
        ]);
    });
    }
}
