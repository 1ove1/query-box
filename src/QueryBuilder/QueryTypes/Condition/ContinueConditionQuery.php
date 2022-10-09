<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Condition;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;

abstract class ContinueConditionQuery
	extends ActiveRecordImpl
	implements ContinueConditionAble
{
use ContinueConditionTrait;
}