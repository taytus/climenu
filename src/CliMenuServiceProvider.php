<?php

namespace taytus\climenu;

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

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}