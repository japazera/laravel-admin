<?php

namespace Japazera\LaravelAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Japazera\LaravelAdmin\Commands\MakeCrud;
use Japazera\LaravelAdmin\Commands\MakeCrm;
use Japazera\LaravelAdmin\Commands\Init;

class LaravelAdminServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->commands([
                Init::class,
				MakeCrud::class,
                MakeCrm::class,
            ]);
        }
    }
}
