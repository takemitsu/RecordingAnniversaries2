<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.debug')) {
            DB::listen(function ($query) {
                info($query->sql);
                info($query->bindings);
                info($query->time);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
