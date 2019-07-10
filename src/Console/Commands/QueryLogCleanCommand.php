<?php

namespace Amethyst\Console\Commands;

use Amethyst\Managers\QueryLogManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class QueryLogCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amethyst:query-log:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old logs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $m = new QueryLogManager();
        $m->getRepository()->deleteOldLogs(intval(Config::get('amethyst.query-log.max_age')));
    }
}
