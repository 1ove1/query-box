<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\Condition;

use QueryBox\QueryBuilder\QueryTypes\Condition\ContinueConditionAble;
use QueryBox\QueryBuilder\QueryTypes\Condition\ContinueConditionTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class ContinueConditionMock extends FakeActiveRecordImpl implements ContinueConditionAble
{
	use ContinueConditionTrait;
}