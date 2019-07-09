<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\QueryLogFaker;
use Amethyst\Managers\QueryLogManager;
use Amethyst\Tests\BaseTest;
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
