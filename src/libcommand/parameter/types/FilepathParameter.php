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

/**
 * @extends Parameter<string>
 */
class FilepathParameter extends Parameter {

	public function parse(CommandSender $sender, array &$input): string {
		$value = array_shift($input);
		return $value ?? throw new AssumptionFailedError("Value expected");
	}

	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && preg_match("/^(.+)\/([^\/]+)$/", $value);
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_FILEPATH;
	}
}