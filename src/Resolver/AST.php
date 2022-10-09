<?php declare(strict_types=1);

namespace QueryBox\Resolver;

use QueryBox\QueryBuilder\QueryTypes\{Join\ImplRightJoin};
use QueryBox\QueryBuilder\QueryTypes\Condition\ImplCondition;
use QueryBox\QueryBuilder\QueryTypes\Condition\ImplConditionAnd;
use QueryBox\QueryBuilder\QueryTypes\Condition\ImplConditionOr;
use QueryBox\QueryBuilder\QueryTypes\Condition\ImplNestedCondition;
use QueryBox\QueryBuilder\QueryTypes\Condition\ImplNestedConditionAnd;
use QueryBox\QueryBuilder\QueryTypes\Condition\ImplNestedConditionOr;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ImplNestedWhereAnd;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ImplNestedWhereOr;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ImplWhereAnd;
use QueryBox\QueryBuilder\QueryTypes\ContinueWhere\ImplWhereOr;
use QueryBox\QueryBuilder\QueryTypes\Delete\ImplDelete;
use QueryBox\QueryBuilder\QueryTypes\Insert\ImplInsert;
use QueryBox\QueryBuilder\QueryTypes\Join\ImplInnerJoin;
use QueryBox\QueryBuilder\QueryTypes\Join\ImplLeftJoin;
use QueryBox\QueryBuilder\QueryTypes\Limit\ImplLimit;
use QueryBox\QueryBuilder\QueryTypes\OrderBy\ImplOrderBy;
use QueryBox\QueryBuilder\QueryTypes\Select\ImplSelect;
use QueryBox\QueryBuilder\QueryTypes\Update\ImplUpdate;
use QueryBox\QueryBuilder\QueryTypes\Where\ImplNestedWhere;
use QueryBox\QueryBuilder\QueryTypes\Where\ImplWhere;

class AST
{
	const COND = 'conditions';
	const COND_EQ = '=';
	const COND_EQL = '<=';
	const COND_EQH = '>=';
	const COND_L = '<';
	const COND_H = '>';
	const COND_LIKE = 'LIKE';
	const COND_ILIKE = 'ILIKE';


	const SQL = 'sql';
	const SQL_SELECT = ImplSelect::class;

	const SQL_INSERT = ImplInsert::class;
	const SQL_UPDATE = ImplUpdate::class;
	const SQL_DELETE = ImplDelete::class;

	const SQL_WHERE = ImplWhere::class;
	const SQL_WHERE_AND = ImplWhereAnd::class;
	const SQL_WHERE_OR = ImplWhereOr::class;
	const SQL_WHERE_NESTED = ImplNestedWhere::class;
	const SQL_WHERE_NESTED_AND = ImplNestedWhereAnd::class;
	const SQL_WHERE_NESTED_OR = ImplNestedWhereOr::class;

	const SQL_COND = ImplCondition::class;
	const SQL_COND_AND = ImplConditionAnd::class;
	const SQL_COND_OR = ImplConditionOr::class;

	const SQL_COND_NESTED = ImplNestedCondition::class;
	const SQL_COND_NESTED_AND = ImplNestedConditionAnd::class;
	const SQL_COND_NESTED_OR = ImplNestedConditionOr::class;

	const SQL_JOIN_INNER = ImplInnerJoin::class;
	const SQL_JOIN_LEFT = ImplLeftJoin::class;
	const SQL_JOIN_RIGHT = ImplRightJoin::class;

	const SQL_LIMIT = ImplLimit::class;
	const SQL_ORDER_BY = ImplOrderBy::class;

	const FMT = 'fmt';
	const FMT_SEP = ' ';
	const FMT_PS_FIELDS = '.';
	const FMT_PS_TABLES = ' as ';
}