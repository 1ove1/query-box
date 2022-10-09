<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Join;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereAble;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereTrait;

abstract class JoinQuery
	extends ActiveRecordImpl
	implements WhereAble, JoinAble
{
use WhereTrait, JoinTrait;

}