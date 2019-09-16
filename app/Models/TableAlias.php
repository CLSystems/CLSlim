<?php
declare(strict_types=1);

namespace CLSlim\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class TableAlias
 *
 * @mixin Builder
 */
abstract class TableAlias extends ModelBase
{
    public const FIELDS = [];

    /**
     * Return the name of the primary key column (usually but not always "id")
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

	/**
	 * @return string
	 */
    public function getTableName(): string
    {
        return $this->table;
    }
}
