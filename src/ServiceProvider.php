<?php

namespace Dexalt142\SendTalk;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    /**
     * The config path of the package.
     * 
     * @var string
     */
    private $configPath = __DIR__.'/../config/sendtalk.php';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        
        $this->publishes([
            $this->configPath => config_path('sendtalk.php')
        ], 'config');

    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {

        $this->mergeConfigFrom($this->configPath, 'sendtalk');

        $this->app->singleton(SendTalk::class, function ($app) {
            return new SendTalk($app['config']['sendtalk.key']);
        });

    }

}