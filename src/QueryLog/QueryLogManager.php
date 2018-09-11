<?php

namespace Railken\LaraOre\QueryLog;

use Illuminate\Support\Facades\Config;
use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Tokens;

class QueryLogManager extends ModelManager
{
    /**
     * Class name entity.
     *
     * @var string
     */
    public $entity = QueryLog::class;

    /**
     * Describe this manager.
     *
     * @var string
     */
    public $comment = 'Rapresentation of a presumed critical query';

    /**
     * List of all attributes.
     *
     * @var array
     */
    protected $attributes = [
        Attributes\Id\IdAttribute::class,
        Attributes\CreatedAt\CreatedAtAttribute::class,
        Attributes\UpdatedAt\UpdatedAtAttribute::class,
        Attributes\Sql\SqlAttribute::class,
        Attributes\Time\TimeAttribute::class,
        Attributes\Group\GroupAttribute::class,
    ];

    /**
     * List of all exceptions.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_AUTHORIZED => Exceptions\QueryLogNotAuthorizedException::class,
    ];

    /**
     * Construct.
     *
     * @param AgentContract $agent
     */
    public function __construct(AgentContract $agent = null)
    {
        $this->entity = Config::get('ore.query-log.entity');
        $this->attributes = array_merge($this->attributes, array_values(Config::get('ore.query-log.attributes')));

        $classRepository = Config::get('ore.query-log.repository');
        $this->setRepository(new $classRepository($this));

        $classSerializer = Config::get('ore.query-log.serializer');
        $this->setSerializer(new $classSerializer($this));

        $classAuthorizer = Config::get('ore.query-log.authorizer');
        $this->setAuthorizer(new $classAuthorizer($this));

        $classValidator = Config::get('ore.query-log.validator');
        $this->setValidator(new $classValidator($this));

        parent::__construct($agent);
    }
}
