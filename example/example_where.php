<?php declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use QueryBox\Examples\Prelude\Models\TestTable;

TestTable::insert([
	'desc' => ['data10', 'data10000', 'data1', 'data100'],
])->save();

$data = TestTable::select()->where(['desc'], 'data10000')->save()->fetchAll();

echo TestTable::tableQuoted() . ' where data10000 result: ' . print_r($data, true) . PHP_EOL;