<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Insert;


use QueryBox\QueryBuilder\Helper;


class ImplInsert extends InsertQuery
{
	/**
	 * @param array<int, int|string> $fields
	 * @param array<DatabaseContract> $values
	 * @param string $tableName
	 */
	public function __construct(array $fields, array $values, string $tableName)
	{
		$fieldsStr = implode(', ', $fields);
		$varsTemplate = Helper::genInsertVars(count($fields), intdiv(count($values), count($fields)));

		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$tableName, $fieldsStr, $varsTemplate],
				dryArgs: $values
			)
		);
	}
}