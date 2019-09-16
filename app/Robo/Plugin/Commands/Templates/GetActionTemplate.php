<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use CLSlim\Controllers\GetActionBase;
use CLSlim\Models\TableAlias;

class TableAliasGetAction extends GetActionBase
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
