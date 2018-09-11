<?php

namespace Railken\LaraOre\QueryLog;

use Faker\Factory;
use Railken\Bag;
use Railken\Laravel\Manager\BaseFaker;

class QueryLogFaker extends BaseFaker
{
    /**
     * @var string
     */
    protected $manager = QueryLogManager::class;

    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('sql', 'SELECT * FROM foo');
        $bag->set('time', 0.23);
        $bag->set('group', 1);

        return $bag;
    }
}
