<?php

namespace Railken\Amethyst\Tests\Commands;

use Railken\Amethyst\Fakers\QueryLogFaker;
use Railken\Amethyst\Managers\QueryLogManager;
use Railken\Amethyst\Tests\BaseTest;

class CleanQueryTest extends BaseTest
{
    public function testCommand()
    {
        // Create a record
        $m = new QueryLogManager();
        $result = $m->create(QueryLogFaker::make()->parameters());
        $this->assertEquals(true, $result->ok());
        config(['amethyst.query-log.min_time' => 0, 'amethyst.query-log.min_queries' => 0]);

        $resource = $result->getResource();
        $resource->created_at = (new \DateTime())->modify('-11 days');
        $resource->save();

        $this->assertEquals($resource->id, $m->getRepository()->findOneById($resource->id)->id);

        $this->artisan('amethyst:query-log:clean');

        $this->assertEquals(null, $m->getRepository()->findOneById($resource->id));

        $this->app->terminate();
    }
}
