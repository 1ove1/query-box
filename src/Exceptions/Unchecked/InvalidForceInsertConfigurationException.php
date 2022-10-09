<?php declare(strict_types=1);

namespace QueryBox\Exceptions\Unchecked;

use QueryBox\Exceptions\ExceptionCodes;
use RuntimeException;

class InvalidForceInsertConfigurationException extends RuntimeException
{
	public function __construct(string $message)
	{
		parent::__construct(
			$message,
			ExceptionCodes::INVALID_FORCE_INSERT_CONFIGURATION_CODE
		);
	}

}