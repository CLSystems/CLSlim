<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use CLSlim\Controllers\QueryValidatorBase;
use CLSlim\Models\TableAlias;

/**
 * Class TableAliasQueryValidator
 *
 * @package CLSlim\Controllers\TableAlias
 */
class TableAliasQueryValidator extends QueryValidatorBase
{
	/**
	 * @var array
	 */
    protected $modelFields = TableAlias::FIELDS;
}
