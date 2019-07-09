<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class QueryLogAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'query-log.create',
        Tokens::PERMISSION_UPDATE => 'query-log.update',
        Tokens::PERMISSION_SHOW   => 'query-log.show',
        Tokens::PERMISSION_REMOVE => 'query-log.remove',
    ];
}
