<?php
/**
 *  _ _ _                                                   _
 * | (_) |                                                 | |
 * | |_| |__   ___ ___  _ __ ___  _ __ ___   __ _ _ __   __| |
 * | | | '_ \ / __/ _ \| '_ ` _ \| '_ ` _ \ / _` | '_ \ / _` |
 * | | | |_) | (_| (_) | | | | | | | | | | | (_| | | | | (_| |
 * |_|_|_.__/ \___\___/|_| |_| |_|_| |_| |_|\__,_|_| |_|\__,_|
 *
 * This library is free software licensed under the MIT license.
 * For more information about the license, visit the link below:
 *
 * https://opensource.org/licenses/MIT
 *
 * Copyright (c) 2022 Matthew Jordan
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