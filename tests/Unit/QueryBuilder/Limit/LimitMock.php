<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\Limit;

use QueryBox\QueryBuilder\QueryTypes\Limit\LimitAble;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class LimitMock extends FakeActiveRecordImpl implements LimitAble
{
	use LimitTrait;
}