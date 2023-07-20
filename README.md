# Query Box - immutable SQL query builder with minimum dependencies
### Description
Actual features:
+ Select, insert, update, delete;
+ Where, join (inner, left, right), limit, order by;
+ Sub select queries;
+ Simple migration tools.
### Setup

1. Instal package from composer:
```bash
composer reuire 1owe1/query-box
```
2. Setup db connection params in your $_ENV directly (like bootstrap action) or use .env parser instead:
```php
// PHP version

// required params
$_ENV["DB_USER"] = "default_user";
$_ENV["DB_PASS"] = "password";
$_ENV["DB_NAME"] = "default";

// optional params
$_ENV["DB_TYPE"] = "mysql"; // or "pgsql" ("mysql" by default)
$_ENV["DB_HOST"] = "127.0.0.1"; // localhost by default
$_ENV["DB_PORT"] = "3306"; // 3306 by default

// extra params
$_ENV["LOG_QUERY_RESULTS"] = "true" // false by default
$_ENV["LOG_PATH"] = "/my/log/path" // by default use stdOut
```

```.env
# .ENV version

# required params
DB_USER="default_user";
DB_PASS="password";
DB_NAME="default";

# optional params
DB_TYPE="mysql"; # or "pgsql" ("mysql" by default)
DB_HOST="127.0.0.1"; # localhost by default
DB_PORT="3306"; # 3306 by default

# extra params
LOG_QUERY_RESULTS="true" # false by default
LOG_PATH="/my/log/path" # by default use stdOut
```

3. Create your first model (or use QueryBuilder::table('my_table')):

```php
<?php declare(strict_types=1)

namespace App\Models;

use QueryBox\QueryBuilder\QueryBuilder;
// interface for migration
use QueryBox\Migration\MigrateAble;

class MyTable extends QueryBuilder implements MigrateAble
{

  // MigrateAble implement
  static function migrationParams(): array
  {
    return [
      "fields" => [
        "id" => "BIGINT NO NULL",
        "foreign_id" => "INT NOT NULL",
        "field" => "CHAR(10)",
      ],
      "foreign" {
        "foreign_id" => [ForeignTable::class, "id"],
      }
    ]
  }
}

```

Migration example:

```php

<?php declare(strict_types=1);

use QueryBox\Migration\MetaTable;
use QueryBox\DBFacade;

use App\Models\MyTable;

MetaTable::migrateFromMigrateAble(DBFacade::getDBInstance(), MyTable::class);

```

Usage:

```php
<?php declare(strict_types=1);

use App\Models\MyTable;
use App\Models\AnotherTable;

$queryResult = MyTable::select(["id", "field"])
  ->leftJoin([AnotherTable::table()], ["foreign_id", "id"])
  ->where("field", "LIKE", "something")
  ->orderBy("id")
  ->limit(1)
  ->save();

var_dump($queryResult->fetchAll());

```

### Configuration
App expect these global variables:
+ Debug options:
  + ***$_ENV['LOG_QUERY_RESULTS']*** (boolean, false by default) - logg raw queries into the log file (require log path otherwise log will be output in std);
  + ***$_ENV['LOG_PATH']*** (string) - path to log file;
+ DB connection:
  + ***$_ENV['DB_TYPE']*** (mysql/pgsql, mysql by default) - type of db (for now support only mysql and pgsql);
  + ***$_ENV['DB_NAME'] *(required)*** - name of db;
  + ***$_ENV['DB_HOST']*** (localhost by default) - host of db;
  + ***$_ENV['DB_PORT']*** (3306 by default) - db port;
  + ***$_ENV['DB_USER'] *(required)*** - db username or role;
  + ***$_ENV['DB_PASS'] *(required)*** - db pass.
### Tests
Tests defined into ./test directory (QueryBox\Tests\ namespace), use './vendor/bin/phpunit'.

Also you can use phpstan by './vendor/bin/phpstan' (level 9 by default).
### Examples
You also can find some examples into ./example directory.