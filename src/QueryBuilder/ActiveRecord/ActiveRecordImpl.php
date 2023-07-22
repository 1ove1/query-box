<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\ActiveRecord;

use Monolog\Logger;
use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\QueryResult;
use QueryBox\DBAdapter\QueryTemplate;
use QueryBox\DBFacade;
use QueryBox\Exceptions\Unchecked\BadQueryResultException;
use QueryBox\Resolver\DBResolver;

abstract class ActiveRecordImpl implements ActiveRecord
{
	/** @var QueryBox - query container */
	public readonly QueryBox $queryBox;

	public function __construct(QueryBox $queryBox)
	{
		$this->queryBox = $queryBox;
	}

	/**
	 * {@inheritDoc}
	 */
	public function execute(array $values): QueryResult
	{
		try {
			$db = DBFacade::getDBInstance();
			$querySnapshot = $this->queryBox->getQuerySnapshot();

			return $db->prepare($querySnapshot)->exec($values);
		} catch(BadQueryResultException $e) {
			$db = DBFacade::getImmutableDBConnection();
			$querySnapshot = $this->queryBox->getQuerySnapshot();

			return $db->prepare($querySnapshot)->exec($values);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function save(): QueryResult
	{
		return $this->execute($this->queryBox->getDryArgs());
	}

	/**
	 * {@inheritDoc}
	 */
	public function getQueryBox(): QueryBox
	{
		return $this->queryBox;
	}

	/**
	 * @param array<string|int> $clearArgs
	 * @param array<DatabaseContract> $dryArgs
	 * @param QueryBox|null $parentBox
	 * @return QueryBox
	 */
	protected static function createQueryBox(array     $clearArgs = [],
	                                         array     $dryArgs = [],
	                                         ?QueryBox $parentBox = null): QueryBox
	{
		$template = DBResolver::sql(static::class);

		return new QueryBox($template, $clearArgs, $dryArgs, $parentBox);
	}
}