<?php declare(strict_types=1);

namespace QueryBox\Tests\Mock;

use QueryBox\DBAdapter\QueryResult;

class FakeQueryResult implements QueryResult
{
	/** @var array<int, array<string|int, DatabaseContract>> */
	readonly array $assocFetch;
	/** @var array<int, array<string|int, DatabaseContract>> */
	readonly array $numFetch;
	/** @var int  */
	readonly int $size;

	/**
	 * @param array<int, array<int|string, DatabaseContract>> $data
	 */
	public function __construct(array $data)
	{
		$this->assocFetch = $data;

		$numData = [];
		foreach ($data as $element) {
			$tmpElement = [];
			foreach ($element as $attribute) {
				$tmpElement[] = $attribute;
			}
			$numData[] = $tmpElement;
		}

		$this->numFetch = $numData;

		$this->size = count($numData);
	}

	/**
	 * @inheritDoc
	 */
	function fetchAll(int $flag = \PDO::FETCH_ASSOC): array
	{
		return $this->assocFetch + $this->numFetch;
	}

	/**
	 * @inheritDoc
	 */
	function fetchAllAssoc(): array
	{
		return $this->assocFetch;
	}

	/**
	 * @inheritDoc
	 */
	function fetchAllNum(): array
	{
		return $this->numFetch;
	}

	/**
	 * @inheritDoc
	 */
	function fetchCollumn(): array
	{
		return $this->numFetch[0];
	}

	/**
	 * @inheritDoc
	 */
	function rowCount(): int
	{
		return $this->size;
	}

	/**
	 * @inheritDoc
	 */
	function isEmpty(): bool
	{
		return empty($this->rowCount());
	}

	/**
	 * @inheritDoc
	 */
	function isNotEmpty(): bool
	{
		return !$this->isEmpty();
	}

	/**
	 * @inheritDoc
	 */
	function hasOnlyOneRow(): bool
	{
		return $this->size === 1;
	}

	/**
	 * @inheritDoc
	 */
	function hasManyRows(): bool
	{
		return !$this->hasOnlyOneRow() && $this->isNotEmpty();
	}

}