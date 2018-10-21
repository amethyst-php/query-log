<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Console\Commands\QueryLogCleanCommand;
use Railken\Amethyst\Services\QueryLogger;

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

        if (Schema::hasTable(Config::get('amethyst.query-log.data.query-log.table'))) {
            Event::listen(\Illuminate\Database\Events\QueryExecuted::class, function ($event) {
                $this->app->get('amethyst.query-logger')->handleEvent($event);
            });

            $this->app->terminating(function () {
                $this->app->get('amethyst.query-logger')->terminate();
            });

            $schedule = $this->app->make(Schedule::class);
            $schedule->command('amethyst:query-log:clean')->daily();
        }
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
