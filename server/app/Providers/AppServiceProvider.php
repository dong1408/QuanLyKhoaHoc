<?php

namespace App\Providers;

use App\Service\Auth\AuthService;
use App\Service\Auth\AuthServiceImpl;
use App\Service\TapChi\TapChiService;
use App\Service\TapChi\TapChiServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // dk service
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(TapChiService::class, TapChiServiceImpl::class);
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $migrationsPath = database_path('migrations');
        $directories    = glob($migrationsPath . '/*', GLOB_ONLYDIR);
        $paths          = array_merge([$migrationsPath], $directories);

        $this->loadMigrationsFrom($paths);
    }
}
