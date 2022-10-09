<?php declare(strict_types=1);

namespace QueryBox\Migration\Options;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\QueryResult;
use QueryBox\DBFacade;
use QueryBox\Migration\Container\Query;
use QueryBox\Migration\Container\QueryGenerator;
use QueryBox\Migration\MigrateAble;

abstract class BaseOptionFacade
{
	/**
	 * Check if the class name implements a MigrateAbleInterface
	 *
	 * @param string $className
	 */
	protected static function checkMigrateAble(string $className) : void
	{
		$classExists = class_exists($className);
		$migrateAble = is_a($className, MigrateAble::class, true);

		if (false === $classExists) {
			exit(sprintf(
				"Class %s are not exists" . PHP_EOL,
				$className
			));
		}

		if (false === $migrateAble) {
			exit(sprintf(
				"Invalid class name %s (not a instance of %s)" . PHP_EOL,
				$className, MigrateAble::class
			));
		}
	}

	/**
	 * Check table existing
	 *
	 * @param DBAdapter $db
	 * @param string $tableName - name of table
	 * @return bool
	 */
	protected static function isTableExists(DBAdapter $db, string $tableName): bool
	{
		$container = QueryGenerator::genShowTableQuery();
		$tableList = $db->rawQuery($container)->fetchAll(QueryResult::PDO_F_COL);


		return in_array($tableName, $tableList, true);
	}


	/**
	 * @param DBAdapter $db
	 * @param Query $container
	 * @return void
	 */
	protected static function executeContainer(DBAdapter $db, Query $container): void
	{
		$db->rawQuery($container);
	}

	/**
	 * Generate table name using class name
	 * @param string $className
	 * @return string
	 */
	protected static function genTableNameFromClassName(string $className): string
	{
		return DBFacade::genTableNameByClassName($className);
	}
}