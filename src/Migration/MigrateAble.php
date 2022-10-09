<?php declare(strict_types=1);

namespace QueryBox\Migration;

use QueryBox\Migration\MigrationParams;

interface MigrateAble
{
	/**
	 * @return MigrationParams
	 */
	static function migrationParams(): array;
}