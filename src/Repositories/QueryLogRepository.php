<?php

namespace Amethyst\Repositories;

use Railken\Lem\Repository;

class QueryLogRepository extends Repository
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

    /**
     * Delete logs older than the days defined by the param.
     *
     * @param int $max_age
     */
    public function deleteOldLogs(int $max_age)
    {
        $max_date = (new \DateTime())->modify("-{$max_age} days");

        $this->newQuery()->where('created_at', '<', $max_date)->delete();
    }
}
