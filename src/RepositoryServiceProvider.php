<?php

namespace Yoelfme\Repository;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class RepositoryServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Yoelfme\Repository\Repository', function($app){
            return new Repository($app);
        });
    }
}
