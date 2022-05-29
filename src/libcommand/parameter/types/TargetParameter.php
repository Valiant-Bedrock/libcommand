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
use pocketmine\player\Player;
use pocketmine\Server;
use function assert;
use function is_string;

/**
 * @extends Parameter<Player>
 */
class TargetParameter extends Parameter {

	/**
	 * @param string|array<string> $input
	 * @return Player|null
	 */
	public function parse(string|array $input): ?Player {
		assert(is_string($input));
		return Server::getInstance()->getPlayerExact($input);
	}

	public function validate(array|string $input): bool {
		return is_string($input) && Server::getInstance()->getPlayerExact($input) !== null;
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}
}