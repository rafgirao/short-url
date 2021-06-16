<?php

namespace RafaelGirao\ShortURL\Providers;

use RafaelGirao\ShortURL\Classes\Builder;
use RafaelGirao\ShortURL\Classes\Validation;
use RafaelGirao\ShortURL\Exceptions\ValidationException;
use Illuminate\Support\ServiceProvider;

class ShortURLProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/short-url.php', 'short-url');

        $this->app->bind('short-url.builder', function () {
            return new Builder();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws ValidationException
     */
    public function boot(): void
    {
        // Config
        $this->publishes([
            __DIR__.'/../../config/short-url.php' => config_path('short-url.php'),
        ], 'short-url-config');

//        // Models
//        $this->publishes([
//            __DIR__.'/../../src/Models/ShortURL.php' => app_path('Models/ShortUrl.php'),
//        ], 'short-url-short-url-model');
//
//        $this->publishes([
//            __DIR__.'/../../src/Models/ShortURLVisit.php' => app_path('Models/ShortURLVisit.php'),
//        ], 'short-url-short-url-model');
//
//        // Controller
//        $this->publishes([
//            __DIR__.'/../../src/Controllers/ShortURLController.php' => app_path('Controllers/ShortURLController.php'),
//        ], 'short-url-short-url-controller');

        $this->publishes([
            __DIR__.'/../../src/Models/ShortURLVisit.php' => app_path('Models/ShortURLVisit.php'),
        ], 'short-url-short-url');

        // Migrations
        $this->publishes([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'short-url-migrations');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        if (config('short-url') && config('short-url.validate_config')) {
            (new Validation())->validateConfig();
        }
    }
}
