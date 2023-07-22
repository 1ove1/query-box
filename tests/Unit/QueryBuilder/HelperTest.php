<?php declare(strict_types=1);

namespace QueryBox\Tests\Unit\QueryBuilder;

use PHPUnit\Framework\TestCase;
use QueryBox\QueryBuilder\Helper;

class HelperTest extends TestCase
{
  const CLASS_NAME = self::class;
	const DB_NAME = 'helper_test';

	function testClassNameToDBNameConverter(): void
	{
		$this->assertEquals(self::DB_NAME, Helper::genTableNameByClassName(self::CLASS_NAME));
	}

	/** @var array<string|int, string|array<string>> */
	private array $fieldsWithPseudonyms = [
		'addr' => [
			'one', 'two'
		],
		'house' => 'three',
		'four',
		'five',
	];
	const STRING_FIELDS_WITH_PARAMS_RESULT = '`addr`.`one`, `addr`.`two`, `house`.`three`, `four`, `five`';

	function testFieldsWithPseudonymsToString(): void
	{
		$result = Helper::mappedFieldsToString($this->fieldsWithPseudonyms);
		$this->assertEquals(self::STRING_FIELDS_WITH_PARAMS_RESULT, $result);
	}

	const STRING_TABLENAMES_WITH_PSEUDONYMS_RESULT = '`addr_obj` as `addr`, `houses` as `house`, `four`, `five`';
	/** @var array<string|int, string|array<string>> */
	private array $tableNamesWithPseudonyms = [
		'addr' => 'addr_obj',
		'house' => 'houses',
		'four',
		'five',
	];

	function testTableNamesWithPseudonymsToString(): void
	{
		$result = Helper::mappedTableNamesToString($this->tableNamesWithPseudonyms);
		$this->assertEquals(self::STRING_TABLENAMES_WITH_PSEUDONYMS_RESULT, $result);
	}

	const TABLE_NAME = ['pseudonym1' => 'table'];
	const JOIN_ARGS_PSEUDONYM = [
        'pseudonym1' => 'field1',
        'pseudonym2' => 'field2',
    ];
	const JOIN_ARGS_JUST_FIELDS = [ 'pseudonym1.field1', 'pseudonym2.field2' ];
	const JOIN_ARGS_JUST_FIELDS_WRAPPED = [ '`pseudonym1`.`field1`', '`pseudonym2`.`field2`' ];
	const JOIN_ARGS_JUST_FIELDS_ASSOC = [ 'pseudonym1.field1' => 'pseudonym2.field2' ];
	const JOIN_ARGS_RESULT = ['tableName' => '`table` as `pseudonym1`', 'condition' => self::JOIN_ARGS_JUST_FIELDS];
	const JOIN_ARGS_RESULT_WRAPPED = ['tableName' => '`table` as `pseudonym1`', 'condition' => self::JOIN_ARGS_JUST_FIELDS_WRAPPED];

	function JoinArgsHandler(): void
	{
		$result1 = Helper::joinArgsHandler(self::TABLE_NAME, self::JOIN_ARGS_PSEUDONYM);
		$result2 = Helper::joinArgsHandler(self::TABLE_NAME, self::JOIN_ARGS_JUST_FIELDS);
		$result3 = Helper::joinArgsHandler(self::TABLE_NAME,self::JOIN_ARGS_JUST_FIELDS_ASSOC);

		$this->assertEquals(self::JOIN_ARGS_RESULT, $result1);
		$this->assertEquals(self::JOIN_ARGS_RESULT, $result2);
		$this->assertEquals(self::JOIN_ARGS_RESULT, $result3);
	}
}