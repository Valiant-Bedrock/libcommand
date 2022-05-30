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

namespace libcommand\parameter\types;

use libcommand\parameter\Parameter;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use function is_string;

/**
 * @extends Parameter<string>
 */
class SubcommandParameter extends Parameter {

	/**
	 * @param string $name
	 */
	public function __construct(string $name) {
		parent::__construct($name, false);
	}

	public function parse(array|string $input): string {
		return $this->name;
	}

	public function validate(array|string $input): bool {
		return is_string($input) && $this->name === $input;
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_COMMAND;
	}
}