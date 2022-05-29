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
use function assert;

/**
 * @extends Parameter<string>
 */
class StringParameter extends Parameter {

	/**
	 * @param string|array<string> $input
	 * @return string
	 */
	public function parse(string|array $input): string {
		assert(is_string($input));
		return $input;
	}

	public function getRequiredNumberOfArguments(): int {
		return 1;
	}

	/**
	 * @param array<string>|string $input
	 * @return bool
	 */
	public function validate(array|string $input): bool {
		return true;
	}
}