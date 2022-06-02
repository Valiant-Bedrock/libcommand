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
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use function count;

/**
 * TODO: DO NOT USE YET! This parameter can not yet parse offsets.
 *
 * @extends Parameter<Vector3>
 */
class Vector3Parameter extends Parameter {

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return Vector3
	 */
	public function parse(CommandSender $sender, array &$input): Vector3 {
		[$x, $y, $z] = array_splice($input, 0, 3);
		return new Vector3(x: floatval($x), y: floatval($y), z: floatval($z));
	}

	public function validate(CommandSender $sender, array &$input): bool {
		return count(array_splice($input, 0, 3)) === 3;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_INT_POSITION;
	}
}