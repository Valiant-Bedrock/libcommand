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
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

/**
 * TODO: DO NOT USE YET! The current system does not allow for unlimited argument counts (which is a sort of basis for this parameter type)
 *
 * @extends Parameter<string>
 */
class StringParameter extends Parameter {

	public function parse(array|string $input): string {
		assert(is_string($input));
		return $input;
	}

	public function validate(array|string $input): bool {
		return is_string($input);
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_STRING;
	}
}