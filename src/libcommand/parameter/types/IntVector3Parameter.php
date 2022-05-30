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

use pocketmine\math\Vector3;

class IntVector3Parameter extends Vector3Parameter {

	/**
	 * @param string|array<string> $input
	 * @return Vector3
	 */
	public function parse(string|array $input): Vector3 {
		assert(is_array($input));
		[$x, $y, $z] = $input;
		return new Vector3(x: intval($x), y: intval($y), z: intval($z));
	}

}