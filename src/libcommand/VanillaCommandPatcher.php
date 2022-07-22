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

namespace libcommand;

use pocketmine\event\EventPriority;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\plugin\PluginBase;

/**
 * This utility class is used to patch vanilla command overloads to allow for client-side rendering.
 */
final class VanillaCommandPatcher {

	public static bool $registered = false;

	public static function register(PluginBase $plugin): void {
		if (self::$registered) {
			return;
		}
		self::$registered = true;
		$plugin->getServer()->getPluginManager()->registerEvent(
			event: DataPacketSendEvent::class,
			handler: function (DataPacketSendEvent $event): void {
				foreach ($event->getPackets() as $packet) {
					if ($packet instanceof AvailableCommandsPacket) {
						foreach ($packet->commandData as $command) {
							if (($data = VanillaCommands::fromString($command->name)) !== null) {
								$command->overloads = $data->getMappedOverloads();
							}
						}
					}
				}
			},
			priority: EventPriority::HIGHEST,
			plugin: $plugin
		);
	}

}