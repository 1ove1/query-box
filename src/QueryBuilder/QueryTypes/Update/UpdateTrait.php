<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Update;

use QueryBox\QueryBuilder\QueryBuilder;

trait UpdateTrait
{
	public static function update(string $field,
	                              float|int|bool|string|null $value,
	                              ?string $tableName = null): UpdateQuery
	{
		$tableName ??= QueryBuilder::tableQuoted(static::class);

		$field = "`{$field}`";

		return new ImplUpdate($field, $value, $tableName);
	}
}