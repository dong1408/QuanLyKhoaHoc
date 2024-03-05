<?php

namespace App\Providers;

use App\Service\Auth\AuthService;
use App\Service\Auth\AuthServiceImpl;
use App\Service\TapChi\PhanLoaiTapChiService;
use App\Service\TapChi\PhanLoaiTapChiServiceImpl;
use App\Service\TapChi\TapChiService;
use App\Service\TapChi\TapChiServiceImpl;
use App\Service\UserInfo\QuocGiaService;
use App\Service\UserInfo\QuocGiaServiceImpl;
use App\Service\UserInfo\TinhThanhService;
use App\Service\UserInfo\TinhThanhServiceImpl;
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
        $this->app->bind(PhanLoaiTapChiService::class, PhanLoaiTapChiServiceImpl::class);
        $this->app->bind(QuocGiaService::class, QuocGiaServiceImpl::class);
        $this->app->bind(TinhThanhService::class, TinhThanhServiceImpl::class);
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
