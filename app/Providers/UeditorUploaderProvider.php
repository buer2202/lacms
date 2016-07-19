<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UeditorUploaderProvider extends ServiceProvider
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
        $this->app->singleton('ueditorUploader', function ($app, $myParams) {
            return new \App\Libraries\UeditorUploader(
                $myParams['fieldName'],
                $myParams['config'],
                $myParams['base64']
            );
        });
    }
}
