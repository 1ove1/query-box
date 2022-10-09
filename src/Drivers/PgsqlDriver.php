<?php declare(strict_types=1);

namespace QueryBox\Drivers;

use QueryBox\Resolver\AST;

class PgsqlDriver extends DefaultDriver
{
	/**
	 * @inheritDoc
	 */
	function getDriver(): array
	{
		$driver = parent::getDriver();

		// change LIKE to ILIKE for mysql compatibility
		$driver[AST::COND][AST::COND_LIKE] = 'ILIKE';

		return $driver;
	}
}