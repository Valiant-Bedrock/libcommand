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
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\utils\AssumptionFailedError;

/**
 * @extends Parameter<string>
 */
class EquipmentSlotParameter extends Parameter {

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

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return string
	 */
	public function parse(CommandSender $sender, array &$input): string {
		return array_shift($input) ?? throw new AssumptionFailedError("Expected a value");
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string> $input
	 * @return bool
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && isset(self::ACCEPTED_VALUES[strtolower($value)]);
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_EQUIPMENT_SLOT;
	}
}