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

namespace  libcommand\parameter\types;

use  libcommand\parameter\Parameter;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\AssumptionFailedError;
use function assert;
use function is_string;

/**
 * TODO: This only supports players and not targets like @a, @e, @p, @r, etc.
 *
 * @extends Parameter<Player>
 */
class TargetParameter extends Parameter {

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return Player
	 */
	public function parse(CommandSender $sender, array &$input): Player {
		return Server::getInstance()->getPlayerExact(array_shift($input) ?? throw new AssumptionFailedError("Value expected")) ?? throw new AssumptionFailedError("Player not found");
	}

	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && Server::getInstance()->getPlayerExact($value) instanceof Player;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_TARGET;
	}


}