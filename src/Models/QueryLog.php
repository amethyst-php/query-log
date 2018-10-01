<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Schemas\QueryLogSchema;
use Railken\Lem\Contracts\EntityContract;

class QueryLog extends Model implements EntityContract
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sql'     => 'object',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('amethyst.query-log.managers.query-log.table');
        $this->fillable = (new QueryLogSchema())->getNameFillableAttributes();
    }
}
