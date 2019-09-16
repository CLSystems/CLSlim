<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use CLSlim\Controllers\QueryValidatorBase;
use CLSlim\Models\TableAlias;

class TableAliasQueryValidator extends QueryValidatorBase
{
    protected $modelFields = TableAlias::FIELDS;
}
