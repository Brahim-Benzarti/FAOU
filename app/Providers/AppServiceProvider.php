<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

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
        if(env("APP_ENV")!=="local"){
            URL::forceScheme('https');
        }
        if(env("APP_ENV")==="local"){
            DB::listen(function ($query) {
                error_log($query->sql);     //for logging the actual query
                // ($query->bindings) also available to show
                error_log($query->time);    //for logging the time
            });
        }
    }
}
