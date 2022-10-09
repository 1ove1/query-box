<?php declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use QueryBox\Examples\Prelude\Models\AnotherTestTable;
use QueryBox\Examples\Prelude\Models\TestTable;

// now insert values in tables
AnotherTestTable::insert([
	'id' => [1, 10, 100, 1000, 10000]
])->save();

TestTable::insert([
	'desc' => ['data10', 'data10000', 'data1', 'data100'],
	'id_another_test_table' => [10, 10000, 1, 100]
])->save();

$data = TestTable::select(['desc', 'alt_name' => 'id'])
	->innerJoin(
		['alt_name' => AnotherTestTable::table()],
		['id_another_test_table', 'alt_name' => 'id']
	)->save()->fetchAll();

echo 'Inner join of two tables: ' . print_r($data, true) . PHP_EOL;
