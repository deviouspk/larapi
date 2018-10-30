<?php

namespace Modules\Telescope\Providers;

use DB;
use Foundation\Contracts\ConditionalAutoRegistration;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider implements ConditionalAutoRegistration
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);

        //Telescope::night();

        Telescope::filter(function (IncomingEntry $entry) {
            if ($entry->type === EntryType::REQUEST
                && isset($entry->content['uri'])
                && str_contains($entry->content['uri'], 'horizon')) {
                return false;
            }

            if ($entry->type === EntryType::EVENT
                && isset($entry->content['name'])
                && str_contains($entry->content['name'], 'Horizon')) {
                return false;
            }

            if ($entry->type === EntryType::REQUEST
                && isset($entry->content['method'])
                && $entry->content['method'] ==='OPTIONS'){
                return false;
            }

            if ($this->app->environment('local')) {
                return true;
            }

            return $entry->isReportableException() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });


    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    public function registrationCondition(): bool
    {
        return env('APP_ENV') === 'local';
    }


}