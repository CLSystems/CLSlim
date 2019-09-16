<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use CLSlim\Controllers\WriteActionBase;
use CLSlim\Models\TableAlias;

class TableAliasPostAction extends WriteActionBase
{
    /**
     * @var TableAlias
     */
    protected $model;

    public function __construct(TableAlias $model)
    {
        $this->model = $model;
    }
}
