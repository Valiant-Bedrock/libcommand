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
use pocketmine\utils\AssumptionFailedError;
use function array_shift;
use function is_string;
use function strtolower;

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
	 * @param array<string> $input
	 */
	public function parse(CommandSender $sender, array &$input): string {
		return array_shift($input) ?? throw new AssumptionFailedError("Expected a value");
	}

	/**
	 * @param array<string> $input
	 */
	public function validate(CommandSender $sender, array &$input): bool {
		$value = array_shift($input);
		return is_string($value) && isset(self::ACCEPTED_VALUES[strtolower($value)]);
	}

	public function getType(): int {
		return AvailableCommandsPacket::ARG_TYPE_EQUIPMENT_SLOT;
	}
}