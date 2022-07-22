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
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

/**
 * A command class used to restrict command access to players.
 */
abstract class PlayerCommand extends Command {

	final public function onExecute(CommandSender $sender, array $arguments): bool|string {
		if (!$sender instanceof Player) {
			return TextFormat::RED . "This command can only be used in-game.";
		}
		return $this->onPlayerExecute($sender, $arguments);
	}

	/**
	 * The method that is called when the command is executed by a player.
	 *
	 * @param array<string, mixed> $arguments
	 */
	public abstract function onPlayerExecute(Player $sender, array $arguments): bool|string;
}