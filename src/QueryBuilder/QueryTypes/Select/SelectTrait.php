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
		$fields = (is_string($fields)) ? $fields: DBFacade::mappedFieldsToString($fields);

		$anotherTables = (null === $anotherTables) ? self::tableQuoted(static::class): $anotherTables;

		return new ImplSelect($fields, $anotherTables);
	}
}