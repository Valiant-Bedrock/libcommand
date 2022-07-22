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

namespace libcommand\parameter;

use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

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
	 * @return mixed
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