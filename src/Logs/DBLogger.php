<?php declare(strict_types=1);

namespace QueryBox\Logs;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;
use Monolog\Logger;

class DBLogger
{
	static private function checkGlobalPaths(): void
	{
		if (!isset($_ENV['LOG_PATH'])) {
			throw new \RuntimeException('$_ENV[\'LOG_PATH\'] was not found');
		}
	}

	static function getLoggerImmutable(bool $cli = true): Logger
	{
		self::checkGlobalPaths();

		$logger = new Logger('runtime');
		$fileHandler = new RotatingFileHandler($_ENV['LOG_PATH'] . '/sql_log', 2, Level::Notice);
		$logger->pushHandler($fileHandler);

		$formatter = new LineFormatter(null, "Y-m-d H-m-s", true, true);
		$fileHandler->setFormatter($formatter);

		if ($cli) {
			$systemHandler = new ErrorLogHandler(expandNewlines: true);
			$systemHandler->setFormatter($formatter);
			$logger->pushHandler($systemHandler);
		}

		return $logger;
	}
}