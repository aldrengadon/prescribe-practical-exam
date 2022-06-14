<?php

namespace App\Providers;

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
        view()->composer([
            'layouts/header',
            'layouts/app'],
            'App\Http\ViewComposer\UserComposer');
        view()->composer('layouts/sidebar', 'App\Http\ViewComposer\ModulesComposer');
    }
}
