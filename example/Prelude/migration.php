<?php declare(strict_types=1);

use QueryBox\Examples\Prelude\Models\AnotherTestTable;
use QueryBox\Examples\Prelude\Models\TestTable;

use QueryBox\Exceptions\Unchecked\BadQueryResultException;

use QueryBox\Migration\MetaTable;

// migrate base tables
$migration = MetaTable::createImmutable();

try {
	$migration->doDeleteTableFromMigrateAble(TestTable::class);
	$migration->doDeleteTableFromMigrateAble(AnotherTestTable::class);
} catch (BadQueryResultException $e) {
	echo "Create tables..." . $e->getMessage();
}

$migration->doMigrateFromMigrateAble(AnotherTestTable::class);
$migration->doMigrateFromMigrateAble(TestTable::class);
