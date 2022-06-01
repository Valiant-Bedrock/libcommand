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

class JsonParameter extends StringParameter {

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_JSON;
	}
}