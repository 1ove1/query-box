<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Select;

use QueryBox\DBFacade;

trait SelectTrait
{
	/**
	 * {@inheritDoc}
	 */
	public static function select(array|string $fields = '*',
	                              array|string|null $anotherTables = null): SelectQuery
	{
		$fields = match(is_string($fields)) {
			true =>	$fields,
			false => DBFacade::mappedFieldsToString($fields),
		};

		$anotherTables = match(null === $anotherTables) {
			true => self::tableQuoted(static::class),
			default => $anotherTables
		};

		return new ImplSelect($fields, $anotherTables);
	}
}