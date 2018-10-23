<?php

namespace Railken\Amethyst\Services;

use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Managers\QueryLogManager;

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
        $this->shouldLog = true;
        $this->queryLogs = [];
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

        if ($event->time < Config::get('amethyst.query-log.min_time')) {
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

        if (count($this->queryLogs) < Config::get('amethyst.query-log.min_queries')) {
            return;
        }
        $params = [
            'time'  => 0,
            'sql'   => [],
            'group' => $manager->getRepository()->generateGroup(),
        ];

        foreach ($this->queryLogs as $query) {
            $params['time'] += $query->time;
            $params['sql'][] = ['sql' => $query->sql, 'time' => $query->time];
        }

        $manager->create($params);
    }
}
