<?php

namespace Railken\LaraOre\Services;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\QueryLog\QueryLogManager;

class QueryLogger
{
    /**
     * @var array
     */
    protected $queryLogs = [];

    /**
     * @var bool
     */
    protected $shouldLog = true;

    /**
     * Boot service.
     */
    public function boot()
    {
        return $this->queryLogs = [];
    }

    /**
     * Handle event.
     *
     * @param mixed $event
     */
    public function handleEvent($event)
    {
        if (!$this->shouldLog) {
            return;
        }

        if ($event->time < Config::get('ore.query-log.min_time')) {
            return;
        }

        $bindings = $event->bindings;
        $sql = $event->sql;

        foreach ($bindings as $i => $binding) {
            if ($binding instanceof \DateTime) {
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            } elseif (is_string($binding)) {
                $bindings[$i] = "'$binding'";
            }
        }

        $sql = str_replace(['%', '?'], ['%%', '%s'], $sql);
        $sql = vsprintf($sql, $bindings);

        $this->queryLogs[] = (object) ['sql' => $sql, 'time' => $event->time];
    }

    /**
     * Callback application terminating.
     */
    public function terminate()
    {
        $this->shouldLog = false;

        $manager = new QueryLogManager();

        if (count($this->queryLogs) < Config::get('ore.query-log.min_queries')) {
            return;
        }

        $params = [
            'time'  => 0,
            'sql'   => [],
            'group' => $manager->getRepository()->generateGroup(),
        ];

        foreach ($this->queryLogs as $query) {
            $params['time'] += $query->time;
            $params['sql'][] = $query->sql;
        }

        $manager->create($params);
    }
}
