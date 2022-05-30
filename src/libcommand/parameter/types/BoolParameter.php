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
 * @extends Parameter<bool>
 */
class BoolParameter extends Parameter {

	/**
	 * @param array<string>|string $input
	 * @return bool
	 */
	public function parse(array|string $input): bool {
		return boolval($input);
	}

	/**
	 * @param array<string>|string $input
	 * @return bool
	 */
	public function validate(array|string $input): bool {
		assert(is_string($input));
		return match(strtolower($input)) {
			"true", "1", "false", "0" => true,
			default => false
		};
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_RAWTEXT;
	}
}