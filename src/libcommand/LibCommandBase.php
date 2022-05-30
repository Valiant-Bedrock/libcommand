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
		if(self::$registered) {
			return;
		}
		$plugin->getServer()->getPluginManager()->registerEvent(
			event: DataPacketSendEvent::class,
			handler: function(DataPacketSendEvent $event): void {
				foreach($event->getPackets() as $packet) {
					if($packet instanceof AvailableCommandsPacket) {
						$commands = self::getCompatibleCommands();
						foreach($commands as $command) {
							$filtered = array_filter($packet->commandData, fn(CommandData $data): bool => $data->name === $command->getName());
							/** @var CommandData $data */
							$data = $filtered[array_key_first($filtered)] ?? null;
							if($data !== null) {
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
				callback: fn(Parameter $parameter) => CommandParameter::standard(
					name: $parameter->getName(),
					type: $parameter->getType(),
					optional: $parameter->isOptional(),
				),
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