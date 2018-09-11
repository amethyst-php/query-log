<?php

namespace Railken\LaraOre\Tests\QueryLog;

use Railken\LaraOre\QueryLog\QueryLogFaker;
use Railken\LaraOre\QueryLog\QueryLogManager;
use Railken\LaraOre\Support\Testing\ManagerTestableTrait;

class ManagerTest extends BaseTest
{
    use ManagerTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
        return new QueryLogManager();
    }

    public function testSuccessCommon()
    {
        $this->commonTest($this->getManager(), QueryLogFaker::make()->parameters());
    }
}
