<?php declare(strict_types=1);

namespace QueryBox\Examples\Prelude\Models;

use QueryBox\Migration\MigrateAble;
use QueryBox\QueryBuilder\QueryBuilder;

class AnotherTestTable extends QueryBuilder implements MigrateAble
{
	/**
	 * @inheritDoc
	 */
	static function migrationParams(): array
	{
		return [
			'fields' => [
				'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT'
			]
		];
	}

}