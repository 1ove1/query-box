<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Delete;

use QueryBox\QueryBuilder\QueryBuilder;

trait DeleteTrait
{
	public static function delete(?string $tableName = null): DeleteQuery
	{
		$tableName ??= QueryBuilder::tableQuoted(static::class);

		return new ImplDelete($tableName);
	}
}