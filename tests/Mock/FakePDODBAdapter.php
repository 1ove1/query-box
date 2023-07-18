<?php declare(strict_types=1);


namespace QueryBox\Tests\Mock;

use QueryBox\DBAdapter\PDO\PDOForceInsertTemplate;
use QueryBox\DBAdapter\QueryTemplate;

class FakePDODBAdapter extends FakeDBAdapter
{
	/**
   * @inheritDoc
   */ 
  public function getForceInsertTemplate(
      string $tableName,
      array $fields,
      int $stagesCount = 1
  ): QueryTemplate
  {
    return new PDOForceInsertTemplate($this, $tableName, $fields, $stagesCount);
  }

}
