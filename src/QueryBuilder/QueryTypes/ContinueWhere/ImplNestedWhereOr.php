<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\ContinueWhere;

use QueryBox\Exceptions\Unchecked\BadQueryBuilderCallbackReturnExcpetion;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;
use QueryBox\QueryBuilder\QueryTypes\Condition\ClientCondition;

class ImplNestedWhereOr extends ContinueWhereQuery
{
	public function __construct(ActiveRecord $parent, callable $callback)
	{
		$record = $callback(new ClientCondition());
		if (!($record instanceof ActiveRecord)) {
			throw new BadQueryBuilderCallbackReturnExcpetion($record);
		}

		$callbackQueryBox = $record->getQueryBox();
		parent::__construct(
			$this->createQueryBox(
				clearArgs: [trim($callbackQueryBox->getQuerySnapshot())],
				dryArgs: $callbackQueryBox->getDryArgs(),
				parentBox: $parent->getQueryBox()
			)
		);
	}
}