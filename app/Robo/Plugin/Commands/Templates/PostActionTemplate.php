<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use CLSlim\Controllers\WriteActionBase;
use CLSlim\Models\TableAlias;

/**
 * Class TableAliasPostAction
 *
 * @package CLSlim\Controllers\TableAlias
 */
class TableAliasPostAction extends WriteActionBase
{
    /**
     * @var TableAlias
     */
    protected $model;

	/**
	 * TableAliasPostAction constructor.
	 *
	 * @param TableAlias $model
	 */
    public function __construct(TableAlias $model)
    {
        $this->model = $model;
    }
}
