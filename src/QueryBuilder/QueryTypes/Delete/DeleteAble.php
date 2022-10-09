<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Delete;

interface DeleteAble
{
	/**
		 * Creating delete template
		 *
		 * @param  string|null $tableName - name of table
		 * @return DeleteQuery
		 */

	public static function delete(?string $tableName = null): DeleteQuery;
}