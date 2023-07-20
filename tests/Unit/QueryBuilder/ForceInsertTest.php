<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder;

use PHPUnit\Framework\TestCase;
use QueryBox\DBAdapter\PDO\PDOForceInsertTemplate;
use QueryBox\Exceptions\Checked\InvalidForceInsertConfigurationException;
use QueryBox\QueryBuilder\QueryBuilder;
use QueryBox\Tests\Mock\FakeDBAdapter;
use QueryBox\Tests\Mock\FakePDODBAdapter;
use RuntimeException;

class ForceInsertTest extends TestCase
{

	function testPDOForceInsertTemplateEmptyFields(): void
	{
		$normalTemplate = new PDOForceInsertTemplate(
			new FakeDBAdapter, "example", ["example_field"]
		);

    $this->expectException(InvalidForceInsertConfigurationException::class);

		$exceptionTemplate = new PDOForceInsertTemplate(
			new FakeDBAdapter, "example", []
		);
	}

	function testQueryBuilderEmptyFieldsForceInsertException(): void
	{
		$queryBuilder = new QueryBuilder([], null, new FakePDODBAdapter());

    $this->expectException(RuntimeException::class);

		$queryBuilder->forceInsert(["qweqwe"]);
	}

	function testQueryBuilderEmptyFieldsSaveForceInsertException(): void
	{
		$queryBuilder = new QueryBuilder([], null, new FakePDODBAdapter());

    $this->expectException(RuntimeException::class);

		$queryBuilder->saveForceInsert(["qweqwe"]);
	}
}