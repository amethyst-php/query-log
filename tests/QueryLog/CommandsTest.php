<?php

namespace Railken\LaraOre\Tests\QueryLog;

use Railken\LaraOre\QueryLog\QueryLogFaker;
use Railken\LaraOre\QueryLog\QueryLogManager;

class CommandsTest extends BaseTest
{
    public function testCommand()
    {
        // Create a record
        $m = new QueryLogManager();
        $result = $m->create(QueryLogFaker::make()->parameters());
        $this->assertEquals(true, $result->ok());

        $resource = $result->getResource();
        $resource->created_at = (new \DateTime())->modify('-11 days');
        $resource->save();

        $this->assertEquals($resource->id, $m->getRepository()->findOneById($resource->id)->id);

        $this->artisan('ore:query-log:clean');

        $this->assertEquals(null, $m->getRepository()->findOneById($resource->id));
    }
}
