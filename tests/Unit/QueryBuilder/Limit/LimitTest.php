<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\Limit;

use QueryBox\QueryBuilder\QueryTypes\Limit\LimitAble;
use QueryBox\Tests\Unit\QueryBuilder\QueryTypesTestCase;

class LimitTest extends QueryTypesTestCase
{
	public LimitAble $builder;

	function setUp(): void
	{
		$this->builder = new LimitMock();
	}

	function testNegativeValueExceptionTest(): void
	{
		$this->expectException(\RuntimeException::class);
		$this->builder->limit(-10);
	}
}