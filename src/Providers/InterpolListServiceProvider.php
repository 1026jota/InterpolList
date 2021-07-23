<?php

namespace Jota\InterpolList\Providers;

use Illuminate\Support\ServiceProvider;
use Jota\InterpolList\Classes\InterpolList;

class InterpolListServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->bind('InterpolList', function () {
            return new InterpolList();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->publishes([
            __DIR__ . '/../../config/interpollist.php' => config_path('interpollist.php'),
        ]);
    }
}
