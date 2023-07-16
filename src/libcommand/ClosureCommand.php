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
 * https://opensource.org/licenses/MIT
 *
 * Copyright (c) 2022 Matthew Jordan
 */
declare(strict_types=1);

namespace libcommand;

use Closure;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\Server;

/**
 * A command class that can be used to create commands without the need for new classes.
 *
 * A simple example may look something like this:
 *
 * Server::getInstance()->getCommandMap()->register(
 *     fallbackPrefix: "simple_commands",
 *     command: new ClosureCommand(
 *         name: "example",
 *         onExecute: function (CommandSender $sender, array $arguments): bool|string {
 *             return "Hello world!";
 *         },
 *         description: "An example command",
 *         usage: "/example"
 *         overloads: []
 *     )
 * );
 */
final class ClosureCommand extends Command{

	/**
	 * @param Closure(CommandSender, string, array<string, mixed>): (bool|string) $onExecute
	 * @param array<string> $aliases
	 * @param array<Overload> $overloads
	 */
	public function __construct(
		string $name,
		protected Closure $onExecute,
		Translatable|string $description = "",
		Translatable|string|null $usageMessage = null,
		array $aliases = [],
		array $overloads = [],
		?string $permission = null,
		?string $permissionMessage = null
	) {
		parent::__construct($name, $description, $usageMessage, $aliases, $overloads, $permission, $permissionMessage);
	}

	public function onExecute(CommandSender $sender, string $overload, array $arguments): bool|string {
		return ($this->onExecute)($sender, $overload, $arguments);
	}
}