# Query Box - immutable SQL query builder with minimum dependencies
### Description
Actual features:
+ Select, insert, update, delete;
+ Where, join (inner, left, right), limit, order by;
+ Sub select queries;
+ Simple migration tools.
### Configuration
App expect these global variables:
+ Debug options:
  + ***$_ENV['LOG_QUERY_RESULTS']*** (true/false) - logg raw queries into the log file (require log path otherwise log will be output in std);
  + ***$_ENV['LOG_PATH']*** (string) - path to log file;
+ DB connection:
  + ***$_ENV['DB_TYPE']*** (mysql/pgsql) - type of db (for now support only mysql and pgsql);
  + ***$_ENV['DB_NAME']*** - name of db;
  + ***$_ENV['DB_HOST']*** - host of db;
  + ***$_ENV['DB_PORT']*** - db port;
  + ***$_ENV['DB_USER']*** - db username or role;
  + ***$_ENV['DB_PASS']*** - db pass.
### Tests
Tests defined into ./test directory (QueryBox\Tests\ namespace).
### Examples
You also can find some examples into ./example directory.