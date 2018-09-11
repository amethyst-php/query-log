<?php

namespace Railken\LaraOre\QueryLog\Exceptions;

class QueryLogNotFoundException extends QueryLogException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'QUERYLOG_NOT_FOUND';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'Not found';
}
