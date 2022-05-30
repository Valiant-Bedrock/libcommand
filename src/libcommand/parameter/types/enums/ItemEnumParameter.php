<?php
/**
 *
 * Copyright (C) 2020 - 2022 | Matthew Jordan
 *
 * This program is private software. You may not redistribute this software, or
 * any derivative works of this software, in source or binary form, without
 * the express permission of the owner.
 *
 * @author sylvrs
 */
declare(strict_types=1);

namespace libcommand\parameter\types\enums;

use libcommand\parameter\types\AbstractEnumParameter;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;

/**
 * @extends AbstractEnumParameter<Item>
 */
class ItemEnumParameter extends AbstractEnumParameter {

	public function __construct(bool $optional = false) {
		parent::__construct("itemName", "Item", [], $optional);
	}

	public function parse(array|string $input): Item {
		assert(is_string($input));
		$item = StringToItemParser::getInstance()->parse($input);
		assert($item instanceof Item);
		return $item;
	}

	public function validate(array|string $input): bool {
		assert(is_string($input));
		return StringToItemParser::getInstance()->parse($input) !== null;
	}

}