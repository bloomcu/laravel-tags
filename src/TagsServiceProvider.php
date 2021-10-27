<?php

namespace BloomCU\Tags;

use Illuminate\Support\ServiceProvider;

class TagsServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        // Register migrations
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }
}
