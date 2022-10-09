<?php declare(strict_types=1);

namespace QueryBox\Migration\Options\Rollback;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\Migration\Container\QueryGenerator;
use QueryBox\Migration\Options\BaseOptionFacade;

class RollbackImpl extends BaseOptionFacade implements Rollback
{
	/**
	 * @inheritDoc
	 */
	static function deleteTable(DBAdapter $db, array|string $tableName): void
	{
		if (is_array($tableName)) {
			$tmpTableNames = [];
			foreach ($tableName as $table) {
				if (false === parent::isTableExists($db, $table)) {
					echo sprintf(
						'Table %s are not exists' . PHP_EOL, $table
					);
				} else {
					$tmpTableNames[] = $table;
				}
			}

			$tableName = implode(', ', $tmpTableNames);
		}

		if (!empty($tableName)) {
			$container = QueryGenerator::genDropTableQuery($tableName);

			self::executeContainer($db, $container);
		}
	}

	/**
	 * @inheritDoc
	 */
	static function deleteTableFromMigrateAble(DBAdapter $db, array|string $className): void
	{
		if (is_array($className)) {
			$tmpTableNames = [];
			foreach ($className as $class) {
				parent::checkMigrateAble($class);
				$tmpTableNames[] = parent::genTableNameFromClassName($class);
			}

			$tableName = $tmpTableNames;
		} else {
			$tableName = parent::genTableNameFromClassName($className);
		}

		self::deleteTable($db, $tableName);
	}
}