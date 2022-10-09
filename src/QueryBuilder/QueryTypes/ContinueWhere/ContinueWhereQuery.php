<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\ContinueWhere;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitAble;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitTrait;
use QueryBox\QueryBuilder\QueryTypes\OrderBy\OrderByAble;
use QueryBox\QueryBuilder\QueryTypes\OrderBy\OrderByTrait;

abstract class ContinueWhereQuery
	extends ActiveRecordImpl
	implements ContinueWhereAble, OrderByAble, LimitAble
{
use ContinueWhereTrait, OrderByTrait, LimitTrait;

}