<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder\Join;

use QueryBox\QueryBuilder\QueryTypes\Join\JoinAble;
use QueryBox\QueryBuilder\QueryTypes\Join\JoinTrait;
use QueryBox\Tests\Mock\FakeActiveRecordImpl;

class JoinMock extends FakeActiveRecordImpl implements JoinAble
{
	use JoinTrait;
}