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

namespace libcommand;

use pocketmine\command\CommandSender;
use pocketmine\player\Player;

abstract class PlayerCommand extends Command {

	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		if(!$sender instanceof Player) {
			$sender->sendMessage("This command can only be used in-game.");
			return false;
		}
		return parent::execute($sender, $commandLabel, $args);
	}
}