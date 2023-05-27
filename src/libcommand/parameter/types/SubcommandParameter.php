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
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use function array_shift;
use function is_string;

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
	 * @param array<string> $input
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && $value === $this->name;
	}

	public function getType(): int {
		return -1;
	}

	public function encode(): CommandParameter {
		return CommandParameter::enum(
			name: $this->name,
			enum: new CommandEnum(enumName: "{$this->name}_values", enumValues: [$this->name]),
			flags: 0,
		);
	}
}