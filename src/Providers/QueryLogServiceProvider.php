<?php

namespace Amethyst\Providers;

use Amethyst\Common\CommonServiceProvider;
use Amethyst\Console\Commands\QueryLogCleanCommand;
use Amethyst\Services\QueryLogger;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;

class QueryLogServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        $this->commands([QueryLogCleanCommand::class]);

        $this->app->get('amethyst.query-logger')->boot();

        $this->app->booted(function () {
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                return;
            }

            if (Schema::hasTable(Config::get('amethyst.query-log.data.query-log.table'))) {
                Event::listen(\Illuminate\Database\Events\QueryExecuted::class, function ($event) {
                    $this->app->get('amethyst.query-logger')->handleEvent($event);
                });

                $this->app->terminating(function () {
                    $this->app->get('amethyst.query-logger')->terminate();
                });

                $schedule = $this->app->make(Schedule::class);
                $schedule->command('amethyst:query-log:clean')->daily();

                if (Config::get('queue.default') !== 'sync') {
                    Event::listen(\Illuminate\Queue\Events\JobProcessing::class, function ($event) {
                        $this->app->get('amethyst.query-logger')->boot();
                    });

                    Event::listen(\Illuminate\Queue\Events\JobFailed::class, function ($event) {
                        $this->app->get('amethyst.query-logger')->terminate();
                    });

                    Event::listen(\Illuminate\Queue\Events\JobProcessed::class, function ($event) {
                        $this->app->get('amethyst.query-logger')->terminate();
                    });
                }
            }
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        parent::register();
        $this->app->singleton('amethyst.query-logger', QueryLogger::class);
    }
}
