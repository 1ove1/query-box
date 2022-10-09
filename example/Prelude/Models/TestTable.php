<?php declare(strict_types=1);

namespace QueryBox\Examples\Prelude\Models;

use QueryBox\Migration\MigrateAble;
use QueryBox\QueryBuilder\QueryBuilder;

class TestTable extends QueryBuilder implements MigrateAble
{
	/**
	 * @inheritDoc
	 */
	static function migrationParams(): array
	{
		return [
			'fields' => [
				'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
				'desc' => 'CHAR(100)',
				'id_another_test_table' => 'INT'
			],
			'foreign' => [
				'id_another_test_table' => [AnotherTestTable::class, 'id']
			]
		];
	}

}