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
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\Server;
use pocketmine\utils\AssumptionFailedError;
use function array_shift;
use function is_string;

class CommandParameter extends Parameter {

	/**
	 * @param array<string> $input
	 */
	public function parse(CommandSender $sender, array &$input): Command {
		return Server::getInstance()->getCommandMap()->getCommand(
			array_shift($input) ?? throw new AssumptionFailedError("Unable to parse input")
		) ?? throw new AssumptionFailedError("Command not found");
	}

	/**
	 * @param array<string> $input
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$name = array_shift($input);
		return is_string($name) && Server::getInstance()->getCommandMap()->getCommand($name) !== null;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_COMMAND;
	}
}