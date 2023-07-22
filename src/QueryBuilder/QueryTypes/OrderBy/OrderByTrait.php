<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\OrderBy;


use QueryBox\QueryBuilder\Helper;

trait OrderByTrait
{
	public function orderBy(string|array $field, bool $asc = true): OrderByQuery
	{
		if (is_array($field)) {
			$field = Helper::mappedFieldsToString($field);
		}
		return new ImplOrderBy($this, $field, $asc);
	}
}