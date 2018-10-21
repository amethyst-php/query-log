<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components.
    |
    */
    'data' => [
        'query-log' => [
            'table'      => 'amethyst_query_logs',
            'comment'    => 'Query Log',
            'model'      => Railken\Amethyst\Models\QueryLog::class,
            'schema'     => Railken\Amethyst\Schemas\QueryLogSchema::class,
            'repository' => Railken\Amethyst\Repositories\QueryLogRepository::class,
            'serializer' => Railken\Amethyst\Serializers\QueryLogSerializer::class,
            'validator'  => Railken\Amethyst\Validators\QueryLogValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\QueryLogAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\QueryLogFaker::class,
            'manager'    => Railken\Amethyst\Managers\QueryLogManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'query-log' => [
                'enabled'     => true,
                'controller'  => Railken\Amethyst\Http\Controllers\Admin\QueryLogsController::class,
                'router'      => [
                    'as'        => 'query-log.',
                    'prefix'    => '/query-logs',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Minium excecution time
    |--------------------------------------------------------------------------
    |
    | Time (milliseconds) to reach necessary to flag the query as critical
    |
    */
    'min_time' => 10,

    /*
    |--------------------------------------------------------------------------
    | Minium query for each group
    |--------------------------------------------------------------------------
    |
    | Count of queries necessary to flag the whole group as crticial
    |
    */
    'min_queries' => 30,

    /*
    |--------------------------------------------------------------------------
    | Max age
    |--------------------------------------------------------------------------
    |
    | Define the number of days to determinate the max age of a log before deletion
    |
    */
    'max_age' => 10,
];