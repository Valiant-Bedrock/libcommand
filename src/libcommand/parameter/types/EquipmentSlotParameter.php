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

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class EquipmentSlotParameter extends StringParameter {

	public const ACCEPTED_VALUES = [
		"slot.armor" => true,
		"slot.armor.head" => true,
		"slot.armor.chest" => true,
		"slot.armor.legs" => true,
		"slot.armor.feet" => true,
		"slot.chest" => true,
		"slot.enderchest" => true,
		"slot.equippable" => true,
		"slot.hotbar" => true,
		"slot.inventory" => true,
		"slot.saddle" => true,
		"slot.weapon.mainhand" => true,
		"slot.weapon.offhand" => true,
	];

	public function validate(array|string $input): bool {
		return is_string($input) && isset(self::ACCEPTED_VALUES[$input]);
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_EQUIPMENT_SLOT;
	}

}