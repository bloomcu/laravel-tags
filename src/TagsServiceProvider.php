<?php

namespace MetriFi\Tags;

use Illuminate\Support\ServiceProvider;

class TagsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register package facade in consuming apps' service container
        // $this->app->bind('tags', function($app) {
        //     return new Tags();
        // });

        // Merge package config with consuming apps' config
        // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'tags');
    }

    public function boot()
    {
        // Register migrations
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        // Register package config giving developers the option to export
        // config to consuming app's config directory for editing
        // Command: php artisan vendor:publish --provider="HeyHarmon\LaravelApify\LaravelApifyServiceProvider" --tag="config"
        // if ($this->app->runningInConsole()) {
        //     $this->publishes([
        //         __DIR__ . '/../config/config.php' => config_path('tags.php'),
        //     ], 'config');
        // }
    }
}
