<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit;

use QueryBox\Migration\Container\QueryGenerator;
use PHPUnit\Framework\TestCase;
use QueryBox\QueryBuilder\QueryBuilder;

class AddrObj extends QueryBuilder {}

class QueryGeneratorTest extends TestCase
{
	private const CREATE_QUERY = 'CREATE TABLE `table_name` (`id` INT, `desc` CHAR(50) NOT NULL, `id_addr` INT, FOREIGN KEY (`id_addr`) REFERENCES `addr_obj` (`id`))';
	private const TABLE_NAME = 'table_name';
	private const TABLE_PARAMS = [
		'fields' => [
			'id' => 'INT',
			'desc' => 'CHAR(50) NOT NULL',
			'id_addr' => 'INT'
		],
		'foreign' => [
			'id_addr' => [AddrObj::class, 'id']
		]
	];

	public function testMakeCreateTableQuery(): void
	{
		$query = QueryGenerator::makeCreateTableQuery(self::TABLE_NAME, self::TABLE_PARAMS);

		$this->assertEquals(self::CREATE_QUERY, $query);
	}
}
