<?php declare(strict_types=1);

namespace QueryBox\Migration;

use QueryBox\Migration\MigrationParams;

interface MigrateAble
{
	/**
	 * @return array {
	 * 	fields: array<string, string>, 
	 * 	foreign?: array<string, string|array<string>>
	 * 	}
	 */
	static function migrationParams(): array;
}