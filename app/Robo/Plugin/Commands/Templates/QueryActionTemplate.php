<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use CLSlim\Controllers\QueryActionBase;
use CLSlim\Models\TableAlias;

/**
 * Class TableAliasQueryAction
 *
 * @package CLSlim\Controllers\TableAlias
 */
class TableAliasQueryAction extends QueryActionBase
{
    /**
     * @var TableAlias
     */
    protected $model;

    /**
     * Get the model via Dependency Injection and save it as a property.
     *
     * @param TableAlias $model
     */
    public function __construct(TableAlias $model)
    {
        $this->model = $model;
    }
}
