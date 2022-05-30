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
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use function assert;
use function floatval;
use function is_numeric;

/**
 * @extends Parameter<float>
 */
class FloatParameter extends Parameter {

	public function parse(string|array $input): float {
		assert(is_string($input));
		return floatval($input);
	}

	public function validate(array|string $input): bool {
		return is_numeric($input);
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_FLOAT;
	}
}