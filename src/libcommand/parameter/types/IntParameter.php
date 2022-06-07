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

namespace  libcommand\parameter\types;

use  libcommand\parameter\Parameter;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\utils\AssumptionFailedError;
use function intval;
use function is_numeric;

class IntParameter extends Parameter {

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return int
	 */
	public function parse(CommandSender $sender, array &$input): int {
		return intval(array_shift($input) ?? throw new AssumptionFailedError("Expected a value"));
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		return is_numeric(array_shift($input));
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_INT;
	}
}