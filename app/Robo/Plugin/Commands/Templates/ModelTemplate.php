<?php
declare(strict_types=1);

namespace CLSlim\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class ModelTemplate extends ModelBase
{
    public const FIELDS = [];

    protected $table = 'TableName';
}
