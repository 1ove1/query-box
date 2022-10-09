<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Update;


class ImplUpdate extends UpdateQuery
{
	function __construct(string $field,
	                     float|int|bool|string|null $value,
	                     string $tableName)
	{
		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$tableName, $field],
				dryArgs: [$value],
			)
		);
	}
}