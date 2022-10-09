<?php declare(strict_types=1);

namespace QueryBox\Drivers;

interface Driver
{
	/**
	 * @return array<string, array<string, string>>
	 */
	function getDriver(): array;
}