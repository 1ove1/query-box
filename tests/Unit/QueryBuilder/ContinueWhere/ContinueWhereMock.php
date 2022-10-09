<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\ContinueWhere;

use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ContinueWhereAble;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ContinueWhereTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class ContinueWhereMock extends FakeActiveRecordImpl implements ContinueWhereAble
{
	use ContinueWhereTrait;
}