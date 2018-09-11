<?php

namespace Railken\LaraOre\QueryLog;

use Railken\Laravel\Manager\ModelRepository;

class QueryLogRepository extends ModelRepository
{
    /**
     * Retrieve a valid group.
     *
     * @return string
     */
    public function generateGroup()
    {
        do {
            $group = base64_encode(random_bytes(10));
        } while ($this->newQuery()->where(['group' => $group])->count() > 0);

        return $group;
    }
}
