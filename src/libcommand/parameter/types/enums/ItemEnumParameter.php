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
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\utils\AssumptionFailedError;

class ItemEnumParameter extends AbstractEnumParameter {

	public function __construct(string $name, bool $optional = false) {
		parent::__construct($name, "Item", [], $optional);
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return Item
	 */
	public function parse(CommandSender $sender, array &$input): Item {
		return $this->parseFromString(array_shift($input) ?? throw new AssumptionFailedError("Expected value")) ?? throw new AssumptionFailedError("Unable to locate block");
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && $this->parseFromString($value) !== null;
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