<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Join;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplRightJoin extends JoinQuery
{
	function __construct(ActiveRecord $parent,
	                     string       $joinTable,
	                     string       $leftField,
	                     string       $rightField)
	{
		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$joinTable, $leftField, $rightField],
				dryArgs: [], parentBox: $parent->getQueryBox()
			)
		);
	}
}