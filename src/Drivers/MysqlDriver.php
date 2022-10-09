<?php declare(strict_types=1);

namespace QueryBox\Drivers;

use QueryBox\Resolver\AST;

class MysqlDriver extends DefaultDriver
{
	/**
	 * @inheritDoc
	 */
	function getDriver(): array
	{
		$driver = parent::getDriver();

		// change ILIKE condition cause in mysql it is not supported
		$driver[AST::COND][AST::COND_ILIKE] = 'LIKE';

		return $driver;
	}


}