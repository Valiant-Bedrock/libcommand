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
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;

/**
 * @extends AbstractEnumParameter<Item>
 */
class ItemEnumParameter extends AbstractEnumParameter {

	public function __construct(string $name, bool $optional = false) {
		parent::__construct($name, "Item", [], $optional);
	}

	public function parse(array|string $input): Item {
		assert(is_string($input));
		$item = $this->parseFromString($input);
		assert($item instanceof Item);
		return $item;
	}

	public function validate(array|string $input): bool {
		assert(is_string($input));
		return $this->parseFromString($input) !== null;
	}

	public function parseFromString(string $input): ?Item {
		if(($item = StringToItemParser::getInstance()->parse($input)) !== null) {
			return $item;
		} elseif(($block = VanillaBlocks::getAll()[strtoupper($input)]) !== null) {
			return $block->asItem();
		}
		return null;
	}

}