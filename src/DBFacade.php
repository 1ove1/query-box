<?php declare(strict_types=1);

namespace QueryBox;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\PDO\PDOObject;
use QueryBox\Exceptions\Checked\ConditionNotFoundException;
use QueryBox\Exceptions\Unchecked\DriverImplementationNotFoundException;
use QueryBox\QueryBuilder\Helper;
use QueryBox\Resolver\DBResolver;
use RuntimeException;
use function ctype_upper;

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
			if (self::$instance === null || self::getImmutable()) {
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
	 * Generate table name in snake_case
	 * @param  string $className - full class name namespace
	 * @return string
	 */
	public static function genTableNameByClassName(string $className): string
	{
		$negStrLen = -strlen($className);
		$tableName = '';

		for ($index = -1, $char = $className[$index];
					$index >= $negStrLen && $char !== '\\' && $char !== null;
					--$index, $char = $className[$index] ?? null) {

			if (ctype_upper($char)) {
				$tableName = '_' . strtolower($char) . $tableName;
			} else {
				$tableName = $char . $tableName;
			}

		}

		return substr($tableName, 1);
	}

	/**
	 * Generate vars for prepared statement (in PDO: '?')
	 * Return example: (?, ..., ?) ... (?, ... , ?)
	 *
	 * @return string - string of vars
	 */
	public static function genInsertVars(int $countOfFields, int $countOfGroups): string
	{
		$vars = sprintf(
			"(%s),",
			substr(str_repeat("?, ", $countOfFields), 0, -2)
		);

		$groupedVars = str_repeat($vars, $countOfGroups);

		return substr($groupedVars, 0, -1);
	}

	/**
	 * @param array<int|string, string|String[]> $fieldsWithPseudonyms
	 * @return string
	 */
	public static function mappedFieldsToString(array $fieldsWithPseudonyms): string
	{
		$strResult = '';

		foreach ($fieldsWithPseudonyms as $pseudonym => $fields) {
			$strBuffer = '';

			if (is_array($fields)) {
				if (is_string($pseudonym)) {
					foreach ($fields as $f) {
						$strBuffer .= "`{$pseudonym}`" . DBResolver::fmtPseudoFields() . "`{$f}`" . ", ";
					}
					$strBuffer = substr($strBuffer, 0, -2);
				} else {
					foreach ($fields as $f) {
						$strBuffer .= "`{$f}`, ";
					}
				}

			} else {
				if (is_string($pseudonym)) {
					$strBuffer = "`{$pseudonym}`" . DBResolver::fmtPseudoFields() . "`{$fields}`";
				} else {
					$strBuffer = "`{$fields}`";
				}
			}

			$strResult .= $strBuffer . ", ";
		}

		return substr($strResult, 0, -2);
	}

	/**
	 * @param array<int|string, string> $mappedTableNames
	 * @return string
	 */
	public static function mappedTableNamesToString(array $mappedTableNames): string
	{
		$strBuffer = '';
		foreach ($mappedTableNames as $map => $tableName) {

			if (is_string($map)) {
				if ($tableName[0] === '(') {
					$strBuffer .= "{$tableName}" . DBResolver::fmtPseudoTables() . "`{$map}`" . ", ";
				} else {
					$strBuffer .= "`{$tableName}`" . DBResolver::fmtPseudoTables() . "`{$map}`" . ", ";
				}

			} else {
				$strBuffer .= "`{$tableName}`" . ", ";
			}
		}

		return substr($strBuffer, 0, -2);
	}

	/**
	 * @param array<int|string, string>|string $field
	 * @param DatabaseContract $sign_or_value
	 * @param DatabaseContract $value
	 * @return array{field: string, sign: string, value: DatabaseContract}
	 */
	public static function whereArgsHandler(array|string                $field,
	                                        int|float|bool|string|null  $sign_or_value = '',
	                                        float|int|bool|string|null  $value = null) : array
	{
		if (is_array($field)) {
			if (count($field) === 1) {
				$field = BuilderHelper::mappedFieldsToString($field);
			} else {
				throw new RuntimeException('You can use WHERE state only with single field element');
			}
		}

		try {
			$sign = DBResolver::cond((string)$sign_or_value);
		} catch (ConditionNotFoundException $e) {
			try {
				if (null !== $value) {
					throw new DriverImplementationNotFoundException($e->dbType, $e->getMessage(), $e);
				}
				$sign = DBResolver::cond_eq();
			} catch (ConditionNotFoundException $e) {
				throw new DriverImplementationNotFoundException($e->dbType, $e->getMessage(), $e);
			}
			$value = $sign_or_value;
		}

		return ['field' => $field, 'sign' => $sign, 'value' => $value];
	}

	/**
	 * @param array<string|int, string>|string $tableName
	 * @param array<string|int, string> $condition - support:
	 * 1. Pseudonym notation
	 *      [
	 *          'pseudonym1' => 'field1',
	 *          'pseudonym2' => 'field2',
	 *      ]
	 * 2. Just-fields notation
	 *      [ 'field1', 'field2' ]
	 * 3. Just-fields notation with assoc
	 *      [ 'field1' => 'field2' ]
	 * @return array{tableName: string, condition: array<int, string>} - pattern: ['tableMame', ['field1_with_or_without_pseudonym', 'field2_with_or_without_pseudonym']
	 */
	public static function joinArgsHandler(array|string $tableName, array $condition): array
	{
		if (is_array($tableName)) {
			if (count($tableName) > 1) {
				throw new \RuntimeException("Too many tablenames (require 1)");
			}
			
			$pseudonym = key($tableName);
			[$pseudonym => $name] = $tableName;
			
			$tableName = "`{$name}`";

			if (is_string($pseudonym)) {
				 $tableName .= DBResolver::fmtPseudoTables() . "`{$pseudonym}`";

			}
		}

		$condition = match (count($condition)) {
			1 => (is_string(key($condition)))
				? [key($condition), current($condition)]
				: throw new RuntimeException('Condition count are incorrect (use [name1 => field1, name2 => field2] or [field1, field2] notation]'),

			2 => self::convertFieldsWithPseudonym($condition),

			default => throw new RuntimeException('Condition count are incorrect (use [name1 => field1, name2 => field2] or [field1, field2] notation]')
		};

		return ['tableName' => $tableName, 'condition' => $condition];
	}

	/**
	 * See DBFacade::joinArgsHandler
	 * @param array<string|int, string> $conditionWithPseudonym
	 * @return array<String> - return format: [field1, field2]
	 */
	private static function convertFieldsWithPseudonym(array $conditionWithPseudonym) : array
	{
		$converted = [];
		foreach ($conditionWithPseudonym as $pseudonym => $field) {

			if (is_string($pseudonym)) {
				$converted[] = "`{$pseudonym}`" . DBResolver::fmtPseudoFields() . "`{$field}`";
			} else {
				$converted[] = "`{$field}`";
			}
		}

		return $converted;
	}
}
