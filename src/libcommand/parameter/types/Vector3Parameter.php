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
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use function count;
use function intval;
use function is_array;

/**
 * @extends Parameter<Vector3>
 */
class Vector3Parameter extends Parameter {

	/**
	 * @param string|array<string> $input
	 * @return Vector3|null
	 */
	public function parse(string|array $input): ?Vector3 {
		if(!is_array($input) || count($input) !== 3) {
			return null;
		}
		[$x, $y, $z] = $input;
		return new Vector3(x: intval($x), y: intval($y), z: intval($z));
	}

	public function validate(array|string $input): bool {
		return is_array($input);
	}

	public function getRequiredNumberOfArguments(): int {
		return 3;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_POSITION;
	}
}