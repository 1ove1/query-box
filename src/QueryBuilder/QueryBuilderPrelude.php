<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\QueryResult;
use QueryBox\DBAdapter\QueryTemplate;
use QueryBox\DBFacade;
use QueryBox\Exceptions\Checked\InvalidForceInsertConfigurationException;
use QueryBox\Logs\DBLogger;
use QueryBox\Migration\MigrateAble;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;
use QueryBox\QueryBuilder\QueryTypes\{Delete\DeleteAble};
use QueryBox\QueryBuilder\QueryTypes\Delete\DeleteTrait;
use QueryBox\QueryBuilder\QueryTypes\Insert\InsertAble;
use QueryBox\QueryBuilder\QueryTypes\Insert\InsertTrait;
use QueryBox\QueryBuilder\QueryTypes\Select\SelectAble;
use QueryBox\QueryBuilder\QueryTypes\Select\SelectTrait;
use QueryBox\QueryBuilder\QueryTypes\Update\UpdateAble;
use QueryBox\QueryBuilder\QueryTypes\Update\UpdateTrait;
use RuntimeException;

/**
 * Common interface for query builder
 */
abstract class QueryBuilderPrelude
	implements SelectAble, InsertAble, UpdateAble, DeleteAble, BuilderOptions
{
use SelectTrait, InsertTrait, UpdateTrait, DeleteTrait;

	/** @var ActiveRecord[] */
	protected readonly array $userStates;
	/** @var QueryTemplate|InvalidForceInsertConfigurationException - force insert template */
	protected readonly QueryTemplate|InvalidForceInsertConfigurationException $forceInsertTemplate;

	/**
	 * @param string|null $tableName
	 * @param array<string> $fields
	 */
	public function __construct( array $fields = [], ?string $tableName = null, ?DBAdapter $db = null)
	{
		$this->userStates = $this->prepareStates();

		$tableName ??= self::table();

		if ($this instanceof MigrateAble) {
			$params = $this::migrationParams();
			if (key_exists('fields', $params)) {
				$fields = array_keys($params['fields']);
			}
		}

		try {
			$db ??= DBFacade::getDBInstance();
			$this->forceInsertTemplate = $db->getForceInsertTemplate(
				tableName: $tableName,
				fields: $fields,
				stagesCount: (int)($_ENV['DB_BUFF'] ?? 1)
			);
		} catch(InvalidForceInsertConfigurationException $e) {
			$this->forceInsertTemplate = $e;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function findFirst(string $field,
	                                 mixed $value,
	                                 ?string $anotherTable = null): QueryResult
	{
		return static::select($field, $anotherTable)->where($field, $value)->save();
	}

	/**
	 * Here you can declare states that you want to use in your pseudo-model
	 *
	 * @return ActiveRecord[]
	 */
	protected function prepareStates(): array
	{
		return [];
	}

	/**
	 * Execute template by name
	 * @param string $templateName
	 * @param array<DatabaseContract> $queryArguments
	 * @return QueryResult
	 */
	public function __call(string $templateName, array $queryArguments)
	{
		$state = $this->userStates[$templateName] ?? null;

		if (null === $state) {
			throw new RuntimeException('Unknown state');
		}

		return $state->execute($queryArguments);
	}

	/**
	 * @inheritDoc
	 */
	public function forceInsert(array $values): QueryResult
	{
		if ($this->forceInsertTemplate instanceof InvalidForceInsertConfigurationException) {
			$message = $this->forceInsertTemplate->getMessage();
			$code = $this->forceInsertTemplate->getCode();
			throw new RuntimeException(
				"Cannot use force insert functional couse:\t{$message}", 
				$code, 
				$this->forceInsertTemplate
			);
		}
		return $this->forceInsertTemplate->exec($values);
	}

	/**
	 * @inheritDoc
	 */
	public function saveForceInsert(): QueryResult
	{
		if ($this->forceInsertTemplate instanceof InvalidForceInsertConfigurationException) {
			$message = $this->forceInsertTemplate->getMessage();
			$code = $this->forceInsertTemplate->getCode();
			throw new RuntimeException(
				"Cannot use force insert functional couse:\t{$message}", 
				$code, 
				$this->forceInsertTemplate
			);
		}
		return $this->forceInsertTemplate->save();
	}

	/**
	 * @inheritDoc
	 */
	static function table(?string $className = null): string
	{
		return Helper::genTableNameByClassName($className ?? static::class);
	}

	/**
	 * @inheritDoc
	 */ 
	static function tableQuoted(?string $className = null): string
	{
		return '`' . self::table($className) . '`';
	}
}