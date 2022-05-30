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

	public function __construct(string $name, bool $optional = false) {
		parent::__construct($name, "Block", [], $optional);
	}

	public function parse(array|string $input): Block {
		assert(is_string($input));
		$block = $this->parseFromString($input);
		assert($block instanceof Block);
		return $block;
	}

	public function validate(array|string $input): bool {
		assert(is_string($input));
		return $this->parseFromString($input) !== null;
	}

	public function parseFromString(string $input): ?Block {
		$blocks = VanillaBlocks::getAll();
		return $blocks[strtoupper($input)] ?? null;
	}
}