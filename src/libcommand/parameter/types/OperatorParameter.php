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

namespace libcommand\parameter\types;

use libcommand\parameter\Parameter;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\utils\AssumptionFailedError;

class OperatorParameter extends Parameter {

	public const ACCEPTED_VALUES = ["+" => true, "-" => true, "*" => true, "/" => true, "%" => true];

	public function parse(CommandSender $sender, array &$input): mixed {
		return array_shift($input) ?? throw new AssumptionFailedError("Expected value");
	}

	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && isset(self::ACCEPTED_VALUES[$value]);
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_OPERATOR;
	}
}