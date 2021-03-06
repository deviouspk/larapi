<?php

namespace Modules\Machine\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Machine\Contracts\MachineServiceContract;
use Modules\Machine\Services\MachineService;

class MachineServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            MachineServiceContract::class,
            MachineService::class
        );
    }
}
