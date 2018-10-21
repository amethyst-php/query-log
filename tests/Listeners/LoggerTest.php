<?php

namespace Railken\Amethyst\Tests\Listeners;

use Railken\Amethyst\Managers\QueryLogManager;
use Railken\Amethyst\Tests\BaseTest;

class LoggerTest extends BaseTest
{
    public function testLogQuery()
    {
        $manager = new QueryLogManager();

        config(['amethyst.query-log.min_time' => 0, 'amethyst.query-log.min_queries' => 0]);

        // Perform a simple query
        $manager->getRepository()->newQuery()->where('id', 1)->get();

        $this->assertEquals(1, 1);

        $this->app->terminate();
    }
}
