<?php declare(strict_types=1);

namespace QueryBox\Tests\Mock;

use QueryBox\DBAdapter\QueryResult;
use QueryBox\DBAdapter\QueryTemplate;
use QueryBox\DBAdapter\QueryTemplateBindAble;

class FakeQueryTemplate implements QueryTemplate, QueryTemplateBindAble
{
  /**
   * @inheritDoc
   */
  public function exec(?array $values = null): QueryResult
  {
    return new FakeQueryResult([]);
  }

	/**
   * @inheritDoc
	 */
	public function save(): QueryResult
  {
    return new FakeQueryResult([]);
  }

  /**
	 * @inheritDoc
	 */
	public function bindParams(array &$params = [], bool $columnMod = false): self
  {
    return $this;
  }

	/**
	 * @inheritDoc
	 */
	public function bindValues(array $values = []): self
  {
    return $this;
  }
  
}