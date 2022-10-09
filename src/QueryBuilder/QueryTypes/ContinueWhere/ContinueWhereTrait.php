<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\ContinueWhere;

use QueryBox\DBFacade;

trait ContinueWhereTrait
{

	/**
	 * @inheritDoc
	 */
	public function andWhere(callable|array|string $field_or_nested_clbk,
	                         int|float|bool|string|null $sign_or_value = null,
	                         float|int|bool|string|null $value = null): ContinueWhereQuery
	{
		if (is_callable($field_or_nested_clbk)) {
			return new ImplNestedWhereAnd($this, $field_or_nested_clbk);
		}

		['field' => $field, 'sign' => $sign, 'value' => $value] = DBFacade::whereArgsHandler($field_or_nested_clbk, $sign_or_value, $value);


		return new ImplWhereAnd($this, $field, $sign, $value);
	}

	/**
	 * @inheritDoc
	 */
	public function orWhere(callable|array|string $field_or_nested_clbk,
	                        int|float|bool|string|null $sign_or_value = null,
	                        float|int|bool|string|null $value = null): ContinueWhereQuery
	{
		if (is_callable($field_or_nested_clbk)) {
			return new ImplNestedWhereOr($this, $field_or_nested_clbk);
		}

		['field' => $field, 'sign' => $sign, 'value' => $value] = DBFacade::whereArgsHandler($field_or_nested_clbk, $sign_or_value, $value);

		return new ImplWhereOr($this, $field, $sign, $value);
	}
}
