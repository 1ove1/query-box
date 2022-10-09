<?php declare(strict_types=1);

namespace QueryBox\Migration;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\Migration\Options\Migrate\{MigrateImpl};
use QueryBox\DBFacade;
use QueryBox\Migration\Options\Migrate\Migrate;
use QueryBox\Migration\Options\Rollback\{RollbackImpl};
use QueryBox\Migration\Options\Rollback\Rollback;

/**
 * Meta table object, that doing all manipulation like creating table, get metadata and other
 *
 */
class MetaTable implements Migrate, MigrateImmutable, Rollback, RollbackImmutable
{
	/**
	 * @param DBAdapter $db - database adapter connection
	 */
	private function __construct(
		/**
		 * @var DBAdapter $db - database object
		 */
		private readonly DBAdapter $db
	) {}

	/**
	 * Create immutable object of MetaTable
	 * @param DBAdapter $db
	 * @return MetaTable
	 */
	static function createImmutable(DBAdapter $db = null): self
	{
		if ($db === null) {
			$db = DBFacade::getImmutableDBConnection();
		}
		return new self($db);
	}

	/**
	 * @inheritDoc
	 */
	static function migrate(DBAdapter $db, string $tableName, array $paramsToCreate): void
	{
		MigrateImpl::migrate($db, $tableName, $paramsToCreate);
	}

	/**
	 * @inheritDoc
	 */
	static function migrateFromMigrateAble(DBAdapter $db, string $className): void
	{
		MigrateImpl::migrateFromMigrateAble($db, $className);
	}

	/**
	 * @inheritDoc
	 */
	function doMigrate(string $tableName, array $paramsToCreate): void
	{
		self::migrate($this->db, $tableName, $paramsToCreate);
	}

	/**
	 * @inheritDoc
	 */
	function doMigrateFromMigrateAble(string $className): void
	{
		self::migrateFromMigrateAble($this->db, $className);
	}

	/**
	 * @inheritDoc
	 */
	static function deleteTable(DBAdapter $db, array|string $tableName): void
	{
		RollbackImpl::deleteTable($db, $tableName);
	}

	/**
	 * @inheritDoc
	 */
	static function deleteTableFromMigrateAble(DBAdapter $db, array|string $className): void
	{
		RollbackImpl::deleteTableFromMigrateAble($db, $className);
	}

	/**
	 * @inheritDoc
	 */
	function doDeleteTable(array|string $tableName): void
	{
		self::deleteTable($this->db, $tableName);
	}

	/**
	 * @inheritDoc
	 */
	function doDeleteTableFromMigrateAble(array|string $className): void
	{
		self::deleteTableFromMigrateAble($this->db, $className);
	}
}
