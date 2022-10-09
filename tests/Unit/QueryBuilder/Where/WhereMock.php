<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\Where;

use QueryBox\QueryBuilder\QueryTypes\Where\WhereAble;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class WhereMock extends FakeActiveRecordImpl implements WhereAble
{
	use WhereTrait;
}