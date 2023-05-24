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
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\AssumptionFailedError;
use function array_shift;
use function is_string;

/**
 * TODO: This only supports players and not targets like @a, @e, @p, @r, etc.
 */
class TargetParameter extends Parameter {

	/**
	 * @param array<string> $input
	 */
	public function parse(CommandSender $sender, array &$input): ?Player {
		return Server::getInstance()->getPlayerExact(array_shift($input) ?? throw new AssumptionFailedError("Value expected"));
	}

	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && Server::getInstance()->getPlayerExact($value) instanceof Player;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_TARGET;
	}

}