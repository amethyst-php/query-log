<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\QueryLog                 newEntity()
 * @method \Amethyst\Schemas\QueryLogSchema          getSchema()
 * @method \Amethyst\Repositories\QueryLogRepository getRepository()
 * @method \Amethyst\Serializers\QueryLogSerializer  getSerializer()
 * @method \Amethyst\Validators\QueryLogValidator    getValidator()
 * @method \Amethyst\Authorizers\QueryLogAuthorizer  getAuthorizer()
 */
class QueryLogManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.query-log.data.query-log';
}
