<?php declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use QueryBox\Examples\Prelude\Models\AnotherTestTable;
use QueryBox\Examples\Prelude\Models\TestTable;

// first show empty content in tables
$dataTestTable = TestTable::select()->save()->fetchAll();
$dataAnotherTestTable = AnotherTestTable::select()->save()->fetchAll();
echo TestTable::tableQuoted() . " table: " . print_r($dataTestTable, true);
echo TestTable::tableQuoted() . " table: " . print_r($dataTestTable, true);

// now insert values in tables
AnotherTestTable::insert([
	'id' => [1, 10, 100, 1000, 10000]
])->save();

TestTable::insert([
	'desc' => ['data1', 'data2', 'data3', 'data4'],
	'id_another_test_table' => 100
])->save();


echo str_repeat("*", 50) . PHP_EOL;
echo "Now after insert:" . PHP_EOL . PHP_EOL;

// show target data in tables
$dataTestTable = TestTable::select()->save()->fetchAll();
$dataAnotherTestTable = AnotherTestTable::select()->save()->fetchAll();

echo TestTable::tableQuoted() . " table: " . print_r($dataTestTable, true);
echo TestTable::tableQuoted() . " table: " . print_r($dataTestTable, true);
