<?php
/**
 *  _ _ _                                                   _
 * | (_) |                                                 | |
 * | |_| |__   ___ ___  _ __ ___  _ __ ___   __ _ _ __   __| |
 * | | | '_ \ / __/ _ \| '_ ` _ \| '_ ` _ \ / _` | '_ \ / _` |
 * | | | |_) | (_| (_) | | | | | | | | | | | (_| | | | | (_| |
 * |_|_|_.__/ \___\___/|_| |_| |_|_| |_| |_|\__,_|_| |_|\__,_|
 *
 * This library is free software licensed under the MIT license.
 * For more information about the license, visit the link below:
 *
 * https://opensource.org/licenses/MIT
 *
 * Copyright (c) 2022 Matthew Jordan
 */
declare(strict_types=1);

namespace libcommand\parameter\types;

use libcommand\parameter\Parameter;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class IntVector3Parameter extends Parameter {

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return Vector3
	 */
	public function parse(CommandSender $sender, array &$input): Vector3 {
		[$x, $y, $z] = array_splice($input, 0, 3);
		return new Vector3(x: intval($x), y: intval($y), z: intval($z));
	}

	public function validate(CommandSender $sender, array &$input): bool {
		return count(array_splice($input, 0, 3)) === 3;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_INT_POSITION;
	}

}