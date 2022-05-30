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
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use function assert;
use function in_array;
use function is_string;

/**
 * @template TValue of mixed
 *
 * @template-extends Parameter<string>
 */
class EnumParameter extends Parameter {

	/**
	 * @param string $name
	 * @param string $enumName
	 * @param array<string> $enumValues
	 * @param bool $optional
	 */
	public function __construct(string $name, protected string $enumName, protected array $enumValues, bool $optional = false) {
		parent::__construct($name, $optional);
	}

	/**
	 * @param array<string>|string $input
	 * @return string
	 */
	public function parse(array|string $input): string {
		assert(is_string($input));
		return $input;
	}

	/**
	 * @param array<string>|string $input
	 * @return bool
	 */
	public function validate(array|string $input): bool {
		return is_string($input) && in_array($input, $this->enumValues, true);
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_FLAG_ENUM;
	}

	public function encode(): CommandParameter {
		return CommandParameter::enum(
			name: $this->name,
			enum: new CommandEnum(enumName: $this->enumName, enumValues: $this->enumValues),
			flags: 0,
			optional: $this->optional
		);
	}
}