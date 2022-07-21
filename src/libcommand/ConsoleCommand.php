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

namespace libcommand;

use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

/**
 * A command class used to restrict command access to the console.
 */
abstract class ConsoleCommand extends Command {

	/**
	 * @param CommandSender $sender
	 * @param array<string, mixed> $arguments
	 * @return string|bool
	 */
	final public function onExecute(CommandSender $sender, array $arguments): string|bool {
		if (!$sender instanceof ConsoleCommandSender) {
			return TextFormat::RED . "This command can only be used by the console.";
		}
		return $this->onConsoleExecute($sender, $arguments);
	}

	/**
	 * The method to execute when the command is executed by the console.
	 *
	 * @param ConsoleCommandSender $sender
	 * @param array<string, mixed> $arguments
	 * @return string|bool
	 */
	public abstract function onConsoleExecute(ConsoleCommandSender $sender, array $arguments): string|bool;
}