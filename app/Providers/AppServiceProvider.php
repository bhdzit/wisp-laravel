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
      $registrar = new \App\Exceptions\ResourceRegistrar($this->app['router']);

    $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
        return $registrar;
    });
    }
}
