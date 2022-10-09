<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Where;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ContinueWhereAble;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ContinueWhereTrait;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitAble;
use QueryBox\QueryBuilder\QueryTypes\Limit\LimitTrait;

abstract class WhereQuery
	extends ActiveRecordImpl
	implements ActiveRecord, ContinueWhereAble, LimitAble
{
use ContinueWhereTrait, LimitTrait;
}