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
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

/**
 * @extends Parameter<bool>
 */
class BoolParameter extends Parameter {

	protected const ENUM_NAME = "Boolean";
	protected const ACCEPTED_VALUES = ["true" => true, "1" => true, "false" => false, "0" => false];

	public function parse(CommandSender $sender, array &$input): bool {
		/** @var string $name */
		$name = array_shift($input);
		return self::ACCEPTED_VALUES[$name] ?? false;
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$name = array_shift($input);
		return is_string($name) && isset(self::ACCEPTED_VALUES[strtolower($name)]);
	}

	public function getType(): int {
		return -1;
	}

	public function encode(): CommandParameter {
		/** @var array<string> $values */
		$values = array_keys(self::ACCEPTED_VALUES);
		return CommandParameter::enum(
			name: $this->name,
			enum: new CommandEnum(enumName: self::ENUM_NAME, enumValues: $values),
			flags: 0,
			optional: $this->optional
		);
	}
}