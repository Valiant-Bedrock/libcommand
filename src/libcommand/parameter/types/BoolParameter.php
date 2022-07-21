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
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

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