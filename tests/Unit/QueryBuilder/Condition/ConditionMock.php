<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\Condition;

use QueryBox\QueryBuilder\QueryTypes\Condition\ConditionAble;
use QueryBox\QueryBuilder\QueryTypes\Condition\ConditionTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class ConditionMock extends FakeActiveRecordImpl implements ConditionAble
{
	use ConditionTrait;
}