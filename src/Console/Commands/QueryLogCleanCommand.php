<?php

namespace Railken\LaraOre\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Railken\LaraOre\QueryLog\QueryLogManager;

class QueryLogCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ore:query-log:clean';

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
        $m->getRepository()->deleteOldLogs(intval(Config::get('ore.query-log.max_age')));
    }
}
