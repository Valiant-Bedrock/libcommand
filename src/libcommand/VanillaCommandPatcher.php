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
		if(self::$registered) {
			return;
		}
		self::$registered = true;
		$plugin->getServer()->getPluginManager()->registerEvent(
			event: DataPacketSendEvent::class,
			handler: function(DataPacketSendEvent $event): void {
				foreach($event->getPackets() as $packet) {
					if($packet instanceof AvailableCommandsPacket) {
						foreach($packet->commandData as $command) {
							if(($data = VanillaCommands::fromString($command->name)) !== null) {
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