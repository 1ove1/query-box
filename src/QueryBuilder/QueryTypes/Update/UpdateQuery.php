<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Update;

use QueryBox\QueryBuilder\ActiveRecord\ActiveRecordImpl;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereAble;
use QueryBox\QueryBuilder\QueryTypes\Where\WhereTrait;

abstract class UpdateQuery
	extends ActiveRecordImpl
	implements WhereAble
{
use WhereTrait;

}