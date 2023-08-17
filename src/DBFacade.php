<?php declare(strict_types=1);

namespace QueryBox;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\PDO\PDOObject;

/**
 * Database facade static class
 *
 * @phpstan-type DBParams array{DB_TYPE?: string, DB_HOST?: string, DB_NAME: string, DB_PORT?: string, DB_USER: string, DB_PASS: string}
 */
class DBFacade
{
	/**
	 * @var DBAdapter|null - database static object
	 */
	public static ?DBAdapter $instance = null;
	/**
	 * @var ?DBParams $connectionParams - cache for connection
	 */	
	protected static ?array $connectionParams = null;
	/**
	 * @var ?bool $immutable - flag (turn off singletone)
	 */
	protected static ?bool $immutable = null;
	
	
	/**
	 * @return DBParams
	 */
	static function getConnectionParams(): array
	{
		if (null !== self::$connectionParams) {
			return self::$connectionParams;
		} else {
			/** @var DBParams */
			$globalVars = $_ENV;
			
			return $globalVars;
		}
	}

	/**
	 * Register DB params and immutable option
	 * If $params is not passed (null) DBFacade will be used $_ENV params and singletone connection
	 * Also DBFacade use $_ENV param with the 'DB_IMMUTABLE' key for connection type manage
	 *
	 * @param ?DBParams $params
	 * @param ?bool $immutable
	 * @return DBAdapter
	 */
	public static function registerGlobalDB(?array $params = null, ?bool $immutable = null): DBAdapter
	{
		self::setConnectionParams($params);
		self::setImmutable($immutable);
		return self::getDBInstance($params);
	}

	/**
	 * Get curr instance of database
	 * 
	 * @param DBParams|null $params
	 * @return DBAdapter
	 */
	public static function getDBInstance(?array $params = null): DBAdapter
	{
			if (self::$instance === null || !self::getImmutable()) {
				self::$instance = self::getImmutableDBConnection($params);

			}

			return self::$instance;
	}

	/**
	 * Immutable connection
	 * 
	 * @param ?DBParams $params
	 * @return DBAdapter
	 */
	public static function getImmutableDBConnection(?array $params = null): DBAdapter
	{
		return self::connectViaPDO($params ?? self::getConnectionParams());
	}

	/**
	 * Connection via PDO
	 *
	 * @param DBParams $params
	 * @return DBAdapter
	 */
	public static function connectViaPDO(array $params): DBAdapter
	{
		return PDOObject::connectViaDSN(
			$params['DB_TYPE'] ?? "mysql", 
			$params['DB_HOST'] ?? "localhost",
			$params['DB_NAME'], 
			$params['DB_PORT'] ?? "3306",
			$params['DB_USER'], 
			$params['DB_PASS']
		);
	}

	/**
	 * @param ?bool $immutable - flag value
	 */
	static function setImmutable(?bool $immutable): void
	{
		self::$immutable = $immutable;
	}
	/**
	 * @return bool
	 */
	static function getImmutable(): bool
	{
		return self::$immutable ?? $_ENV["DB_IMMUTABLE"] ?? false;
	}

	/**
	 * @param ?DBParams $params
	 */
	static function setConnectionParams(?array $params): void
	{
		self::$connectionParams = $params;
	}

	/**
	 * Recreate db instance
	 *
	 * @param array|null $params
	 * @return void
	 */
	static function recreateInstance(?array $params): void
	{
		self::$instance = self::getImmutableDBConnection($params);
	}
}
