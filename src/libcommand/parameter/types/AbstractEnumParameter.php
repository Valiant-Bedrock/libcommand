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
use function array_map;

abstract class AbstractEnumParameter extends Parameter {

	/**
	 * @param array<int, mixed> $enumValues
	 */
	public function __construct(string $name, protected string $enumName, protected array $enumValues, bool $optional = false) {
		parent::__construct($name, $optional);
	}

	/**
	 * @param array<string> $input
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