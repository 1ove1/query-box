<?php declare(strict_types=1);


namespace QueryBox\Tests\Mock;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\QueryResult;
use QueryBox\DBAdapter\QueryTemplate;
use QueryBox\DBAdapter\QueryTemplateBindAble;
use QueryBox\Migration\Container\Query;

class FakeDBAdapter implements DBAdapter
{
  /**
   * @inheritDoc
   */
  static function connectViaDSN(string $dbType, string $dbHost,
	                              string $dbName, string $dbPort,
	                              string $dbUsername, string $dbPass): self
  {
    return new self();  
  }

  /**
	 * @inheritDoc
	 */
  public function rawQuery(Query $query): QueryResult 
  {
    return new FakeQueryResult([]);
  }
  

	/**
   * @inheritDoc
	 */
  public function prepare(string $template): QueryTemplateBindAble
  {
    return new FakeQueryTemplate();
  }

	/**
   * @inheritDoc
   */ 
  public function getForceInsertTemplate(
      string $tableName,
      array $fields,
      int $stagesCount = 1
  ): QueryTemplate
  {
    return new FakeQueryTemplate();
  }

}
