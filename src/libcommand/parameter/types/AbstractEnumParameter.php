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

abstract class AbstractEnumParameter extends Parameter {

	/**
	 * @param string $name
	 * @param string $enumName
	 * @param array<int, mixed> $enumValues
	 * @param bool $optional
	 */
	public function __construct(string $name, protected string $enumName, protected array $enumValues, bool $optional = false) {
		parent::__construct($name, $optional);
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return mixed
	 */
	public abstract function parse(CommandSender $sender, array &$input): mixed;

	public function getType(): int {
		return -1;
	}

	public function encode(): CommandParameter {
		return CommandParameter::enum(
			name: $this->name,
			/** @phpstan-ignore-next-line */
			enum: new CommandEnum(enumName: $this->enumName, enumValues: array_map(fn(mixed $value): string => (string) $value, $this->enumValues)),
			flags: 0,
			optional: $this->optional
		);
	}
}