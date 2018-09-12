<?php

namespace Railken\LaraOre;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Railken\LaraOre\Api\Support\Router;
use Railken\LaraOre\Console\Commands\QueryLogCleanCommand;
use Railken\LaraOre\QueryLog\QueryLogManager;
use Railken\LaraOre\Services\QueryLogger;

class QueryLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../config/ore.query-log.php' => config_path('ore.query-log.php')], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutes();
        $this->commands([QueryLogCleanCommand::class]);

        config(['ore.managers' => array_merge(Config::get('ore.managers', []), [
            QueryLogManager::class,
        ])]);

        $this->app->get('ore.query-logger')->boot();

        if (Schema::hasTable(Config::get('ore.query-log.table'))) {
            Event::listen(\Illuminate\Database\Events\QueryExecuted::class, function ($event) {
                $this->app->get('ore.query-logger')->handleEvent($event);
            });

            $this->app->terminating(function () {
                $this->app->get('ore.query-logger')->terminate();
            });

            $schedule = $this->app->make(Schedule::class);
            $schedule->command('ore:query-log:clean')->daily();
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Railken\LaraOre\ApiServiceProvider::class);
        $this->app->singleton('ore.query-logger', QueryLogger::class);
        $this->mergeConfigFrom(__DIR__.'/../config/ore.query-log.php', 'ore.query-log');
    }

    /**
     * Load routes.
     */
    public function loadRoutes()
    {
        $config = Config::get('ore.query-log.http.admin');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');

                $router->get('/', ['uses' => $controller.'@index']);
                $router->post('/', ['uses' => $controller.'@create']);
                $router->put('/{id}', ['uses' => $controller.'@update']);
                $router->delete('/{id}', ['uses' => $controller.'@remove']);
                $router->get('/{id}', ['uses' => $controller.'@show']);
            });
        }
    }
}
