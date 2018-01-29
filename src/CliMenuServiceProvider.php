<?php

namespace taytus\climenu;
use Artisan;
use Illuminate\Support\ServiceProvider;

class ClimenuServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include __DIR__.'/routes.php';
        $this->publishes([
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');



    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //Artisan::call('migrate', array('--path' => 'app/migrations', '--force' => true));


    }
}