<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class mPDFServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mpdf', function ($app) {
            return new Mpdf();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
