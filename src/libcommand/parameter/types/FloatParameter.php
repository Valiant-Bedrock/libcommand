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
use function assert;
use function floatval;
use function is_numeric;

/**
 * @extends Parameter<float>
 */
class FloatParameter extends Parameter {

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return float
	 */
	public function parse(CommandSender $sender, array &$input): float {
		return floatval(array_shift($input) ?? throw new AssumptionFailedError("Expected value"));
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_numeric($value);
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_FLOAT;
	}
}