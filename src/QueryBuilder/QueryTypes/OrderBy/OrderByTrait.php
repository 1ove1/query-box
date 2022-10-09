<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\OrderBy;

use QueryBox\DBFacade;

trait OrderByTrait
{
	public function orderBy(string|array $field, bool $asc = true): OrderByQuery
	{
		if (is_array($field)) {
			$field = DBFacade::mappedFieldsToString($field);
		}
		return new ImplOrderBy($this, $field, $asc);
	}
}