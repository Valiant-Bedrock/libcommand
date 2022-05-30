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

namespace libcommand\parameter;

use libcommand\parameter\types\RawTextParameter;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

class SubcommandParameter extends RawTextParameter {

	public function encode(): CommandParameter {
		$parameter = CommandParameter::standard(
			name: $this->name,
			type: AvailableCommandsPacket::ARG_FLAG_ENUM | AvailableCommandsPacket::ARG_TYPE_RAWTEXT,
			optional: $this->optional
		);
		$parameter->enum = new CommandEnum(enumName: "{$this->name}_values", enumValues: [$this->name]);
		return $parameter;
	}

}