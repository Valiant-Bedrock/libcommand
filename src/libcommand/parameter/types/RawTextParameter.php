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

class RawTextParameter extends Parameter {

	public function parse(CommandSender $sender, array &$input): string {
		return implode(" ", array_splice($input, 0));
	}

	public function validate(CommandSender $sender, array &$input): bool {
		return count(array_splice($input, 0)) > 0;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_RAWTEXT;
	}
}