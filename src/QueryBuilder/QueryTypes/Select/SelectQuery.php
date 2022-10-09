<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Select;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;
use QueryBox\QueryBuilder\QueryTypes\{Join\JoinTrait};
use QueryBox\QueryBuilder\QueryTypes\Join\JoinAble;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitAble;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitTrait;
use QueryBox\QueryBuilder\QueryTypes\OrderBy\OrderByAble;
use QueryBox\QueryBuilder\QueryTypes\OrderBy\OrderByTrait;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereAble;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereTrait;

abstract class SelectQuery
	extends ActiveRecordImpl
	implements WhereAble, JoinAble, LimitAble, OrderByAble
{
use WhereTrait, JoinTrait, LimitTrait, OrderByTrait;

}