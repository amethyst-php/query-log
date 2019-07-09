<?php

namespace Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class QueryLogFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('sql', ['SELECT * FROM foo']);
        $bag->set('time', 0.23);
        $bag->set('group', 1);

        return $bag;
    }
}
