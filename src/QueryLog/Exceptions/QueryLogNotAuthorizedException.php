<?php

namespace Railken\LaraOre\QueryLog\Exceptions;

class QueryLogNotAuthorizedException extends QueryLogException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'QUERYLOG_NOT_AUTHORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
