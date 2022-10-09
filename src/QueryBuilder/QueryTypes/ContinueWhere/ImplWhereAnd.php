<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\ContinueWhere;

use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\DatabaseContract;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplWhereAnd extends ContinueWhereQuery
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