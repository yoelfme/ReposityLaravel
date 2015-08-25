<?php

namespace Yoelfme\PatternRepository;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PatternRepositoryServiceProvider extends BaseServiceProvider
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
        $this->app->bind('Yoelfme\PatternRepository\Repository', function($app){
            return new Repository($app);
        });
    }
}
