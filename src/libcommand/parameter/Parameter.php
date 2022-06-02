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

use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

/**
 * @template T as mixed
 */
abstract class Parameter {

	public function __construct(protected string $name, protected bool $optional = false) {}

	public function getName(): string {
		return $this->name;
	}

	public function isOptional(): bool {
		return $this->optional;
	}

	/**
	 * Parses the input into a usable format
	 *
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return T
	 */
	public abstract function parse(CommandSender $sender, array &$input): mixed;

	/**
	 * Validates the input argument(s)
	 *
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public abstract function validate(CommandSender $sender, array &$input): bool;

	/**
	 * Returns the parameter type from {@link AvailableCommandsPacket}
	 *
	 * @return int
	 */
	public abstract function getType(): int;

	/**
	 * @return CommandParameter
	 */
	public function encode(): CommandParameter {
		return CommandParameter::standard(
			name: $this->name,
			type: $this->getType(),
			optional: $this->optional
		);
	}
}