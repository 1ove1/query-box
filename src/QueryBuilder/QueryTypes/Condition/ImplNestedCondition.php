<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Condition;

use QueryBox\Exceptions\Unchecked\BadQueryBuilderCallbackReturnExcpetion;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplNestedCondition extends ConditionQuery
{
	public function __construct(callable $callback)
	{
		$record = $callback(new ClientCondition());
		if (!($record instanceof ActiveRecord)) {
			throw new BadQueryBuilderCallbackReturnExcpetion($record);
		}

		$callbackQueryBox = $record->getQueryBox();
		parent::__construct(
			$this->createQueryBox(
				clearArgs: [trim($callbackQueryBox->getQuerySnapshot())],
				dryArgs: $callbackQueryBox->getDryArgs()
			)
		);
	}
}