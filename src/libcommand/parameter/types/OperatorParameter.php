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

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class OperatorParameter extends StringParameter {

	public function validate(array|string $input): bool {
		return is_string($input) && match(strtolower($input)) {
			"+", "-", "*", "/", "%", => true,
			default => false
		};
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_OPERATOR;
	}
}