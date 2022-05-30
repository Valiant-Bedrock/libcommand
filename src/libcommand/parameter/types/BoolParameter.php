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
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

/**
 * @extends Parameter<bool>
 */
class BoolParameter extends Parameter {

	protected const ENUM_NAME = "value";
	protected const ACCEPTED_VALUES = ["true" => true, "1" => true, "false" => true, "0" => true];

	/**
	 * @param array<string>|string $input
	 * @return bool
	 */
	public function parse(array|string $input): bool {
		return boolval($input);
	}

	/**
	 * @param array<string>|string $input
	 * @return bool
	 */
	public function validate(array|string $input): bool {
		return is_string($input) && isset(self::ACCEPTED_VALUES[strtolower($input)]);
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
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