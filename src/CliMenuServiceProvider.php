<?php

namespace taytus\climenu;
use Artisan;
use Illuminate\Support\ServiceProvider;
use taytus\climenu\commands\climenu;
use taytus\climenu\commands\ClimenuDisplay;
use taytus\climenu\commands\ClimenuAdmin;

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
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations',
        //    __DIR__ . '/seeds' =>$this->app->databasePath() . '/seeds'


        ], 'migrations');



    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {



        $this->app['climenu']=$this->app->singleton(Climenu::class, function(){

            return new Climenu();
        });



        $this->commands(
            Climenu::class,ClimenuDisplay::class,ClimenuAdmin::class

        );
        //Artisan::call('migrate', array('--path' => 'app/migrations', '--force' => true));


    }
}