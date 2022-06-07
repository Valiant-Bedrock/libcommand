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

namespace libcommand\parameter\types\enums;

use libcommand\parameter\types\AbstractEnumParameter;
use pocketmine\command\CommandSender;
use pocketmine\utils\AssumptionFailedError;

class EnumParameter extends AbstractEnumParameter {

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return string
	 */
	public function parse(CommandSender $sender, array &$input): string {
		return array_shift($input) ?? throw new AssumptionFailedError("Value expected");
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && in_array($value, $this->enumValues, true);
	}
}