<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(){
        // Schema::defaultStringLength(191);
        date_default_timezone_set('Asia/Tehran');
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        if (!function_exists('public_path')) {
            /**
             * Return the path to public dir
             *
             * @param null $path
             *
             * @return string
             */
            function public_path($path = null)
            {
                return rtrim(app()->basePath('public/' . $path), '/');
            }
        }
    }
    
}
