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

use libcommand\parameter\Parameter;
use pocketmine\event\EventPriority;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandData;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

final class LibCommandBase {

	/** @var array<Command> */
	public static array $commands;

	public static bool $registered = false;

	public static function register(PluginBase $plugin): void {
		if (self::$registered) {
			return;
		}
		$plugin->getServer()->getPluginManager()->registerEvent(
			event: DataPacketSendEvent::class,
			handler: function(DataPacketSendEvent $event): void {
				foreach ($event->getPackets() as $packet) {
					if ($packet instanceof AvailableCommandsPacket) {
						$commands = self::getCompatibleCommands();
						foreach ($commands as $command) {
							$filtered = array_filter($packet->commandData, fn(CommandData $data): bool => $data->name === $command->getName());
							/** @var CommandData $data */
							$data = $filtered[array_key_first($filtered)] ?? null;
							if ($data !== null) {
								$data->overloads = self::mapOverloadsToPacket($command);
							}
						}
					}
				}
			},
			priority: EventPriority::HIGHEST,
			plugin: $plugin
		);
	}

	/**
	 * @param Command $command
	 * @return array<array<CommandParameter>>
	 */
	private static function mapOverloadsToPacket(Command $command): array {
		return array_map(
			callback: fn(Overload $overload) => array_map(
				callback: fn(Parameter $parameter) => $parameter->encode(),
				array: $overload->getParameters()
			),
			array: $command->getOverloads()
		);
	}

	/**
	 * @return array<Command>
	 */
	private static function getCompatibleCommands(): array {
		return self::$commands ??= array_filter(
			array: Server::getInstance()->getCommandMap()->getCommands(),
			callback: fn(\pocketmine\command\Command $command): bool => $command instanceof Command
		);
	}

}