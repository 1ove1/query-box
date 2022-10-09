<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\OrderBy;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplOrderBy extends OrderByQuery
{
	function __construct(ActiveRecord $parent, string $fields, bool $asc)
	{
		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$fields, ($asc) ? 'ASC': 'DESC'],
				parentBox: $parent->getQueryBox()
			)
		);
	}
}