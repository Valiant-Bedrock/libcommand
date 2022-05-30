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


/**
 * @extends AbstractEnumParameter<string>
 */
class EnumParameter extends AbstractEnumParameter {

	public function parse(array|string $input): string {
		assert(is_string($input));
		return $input;
	}
}