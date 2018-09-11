<?php

namespace Railken\LaraOre\QueryLog;

use Railken\Laravel\Manager\ModelAuthorizer;
use Railken\Laravel\Manager\Tokens;

class QueryLogAuthorizer extends ModelAuthorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'query_log.create',
        Tokens::PERMISSION_UPDATE => 'query_log.update',
        Tokens::PERMISSION_SHOW   => 'query_log.show',
        Tokens::PERMISSION_REMOVE => 'query_log.remove',
    ];
}
