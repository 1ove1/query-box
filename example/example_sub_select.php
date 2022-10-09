<?php declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use QueryBox\Examples\Prelude\Models\TestTable;

TestTable::insert([
	'desc' => ['data10', 'data10000', 'data1', 'data100'],
])->save();

$data = TestTable::select(
	['row_count_result' => 'row_count'],
	['row_count_result' => fn() => TestTable::select('COUNT(*) as row_count')]
)->save()->fetchAll();

echo TestTable::tableQuoted() . ' has this count of rows: ' . print_r($data, true) . PHP_EOL;