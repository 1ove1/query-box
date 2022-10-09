<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Limit;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplLimit extends LimitQuery
{
	public function __construct(ActiveRecord $parent, int $count)
	{
		parent::__construct(
			$this->createQueryBox(
				clearArgs: [$count],
				parentBox: $parent->getQueryBox()
			)
		);
	}
}