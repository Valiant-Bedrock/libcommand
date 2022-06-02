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
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
use pocketmine\utils\AssumptionFailedError;

/**
 * @extends AbstractEnumParameter<Block>
 */
class BlockEnumParameter extends AbstractEnumParameter {

	public function __construct(string $name, bool $optional = false) {
		parent::__construct($name, "Block", [], $optional);
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return Block
	 */
	public function parse(CommandSender $sender, array &$input): Block {
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

	public function parseFromString(string $input): ?Block {
		$blocks = VanillaBlocks::getAll();
		return $blocks[strtoupper($input)] ?? null;
	}
}