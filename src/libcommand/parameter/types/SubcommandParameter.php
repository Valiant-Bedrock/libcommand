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
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

/**
 * @extends Parameter<string>
 */
class SubcommandParameter extends Parameter {

	public function __construct(string $name) {
		parent::__construct($name);
	}

	public function parse(CommandSender $sender, array &$input): string {
		// shift the input by one and return the name
		array_shift($input);
		return $this->name;
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && $value === $this->name;
	}

	public function getType(): int {
		return -1;
	}

	public function encode(): CommandParameter {
		$parameter = CommandParameter::standard(
			name: $this->name,
			type: AvailableCommandsPacket::ARG_FLAG_ENUM | AvailableCommandsPacket::ARG_TYPE_RAWTEXT,
			optional: false
		);
		$parameter->enum = new CommandEnum(enumName: "{$this->name}_values", enumValues: [$this->name]);
		return $parameter;
	}
}