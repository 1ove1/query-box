<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\OrderBy;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitAble;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitTrait;

abstract class OrderByQuery
	extends ActiveRecordImpl
	implements LimitAble
{
use LimitTrait;

}