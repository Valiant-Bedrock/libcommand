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
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;

/**
 * @extends AbstractEnumParameter<Block>
 */
class BlockEnumParameter extends AbstractEnumParameter {

	public function __construct(bool $optional = false) {
		parent::__construct("tileName", "Block", [], $optional);
	}

	public function parse(array|string $input): Block {
		assert(is_string($input));
		$block = VanillaBlocks::getAll()[strtoupper($input)];
		assert($block instanceof Block);
		return $block;
	}

	public function validate(array|string $input): bool {
		assert(is_string($input));
		return VanillaBlocks::getAll()[strtoupper($input)] !== null;
	}
}