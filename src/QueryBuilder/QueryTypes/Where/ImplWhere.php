<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Where;

use QueryBox\QueryBuilder\QueryTypes\Where\DatabaseContract;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplWhere extends WhereQuery
{
	/**
	 * @param ActiveRecord $parent
	 * @param string $field
	 * @param string $sign
	 * @param DatabaseContract $value
	 */
	public function __construct(ActiveRecord $parent,
	                            string $field,
	                            string $sign,
	                            float|int|bool|string|null $value)
	{
		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$field, $sign],
				dryArgs: [$value],
				parentBox: $parent->getQueryBox()
			)
		);
	}

}