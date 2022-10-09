<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\OrderBy;

use QueryBox\QueryBuilder\QueryTypes\OrderBy\OrderByAble;
use QueryBox\QueryBuilder\QueryTypes\OrderBy\OrderByTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class OrderByMock extends FakeActiveRecordImpl implements OrderByAble
{
	use OrderByTrait;
}