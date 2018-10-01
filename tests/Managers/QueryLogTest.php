<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\QueryLogFaker;
use Railken\Amethyst\Managers\QueryLogManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class QueryLogTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = QueryLogManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = QueryLogFaker::class;
}
