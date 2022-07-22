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

use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Translatable;
use pocketmine\utils\TextFormat;
use function count;
use function is_string;

abstract class Command extends \pocketmine\command\Command {

	/**
	 * @param Translatable|string|null $usageMessage
	 * @param array<string> $aliases
	 * @param array<Overload> $overloads
	 */
	public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [], protected array $overloads = [], ?string $permission = null, ?string $permissionMessage = null) {
		parent::__construct($name, $description, $usageMessage, $aliases);
		$this->setPermission($permission);
		// Only set the permission message if it's not null.
		if ($permissionMessage !== null) {
			$this->setPermissionMessage($permissionMessage);
		}
	}

	public function registerOverload(Overload $overload): void {
		$this->overloads[$overload->getName()] = $overload;
	}

	public function registerOverloads(Overload ...$overloads): void {
		foreach ($overloads as $overload) {
			$this->registerOverload($overload);
		}
	}

	/**
	 * @return array<Overload>
	 */
	public function getOverloads(): array {
		return $this->overloads;
	}

	/**
	 * @param array<string> $args
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		$arguments = [];
		if (count($this->overloads) > 0) {
			$overload = $this->findOverload($sender, $args);
			if ($overload === null) {
				$sender->sendMessage(TextFormat::RED . $sender->getLanguage()->translate(KnownTranslationFactory::commands_generic_usage($this->getUsage())));
				return false;
			}
			$arguments = $overload->map($sender, $args);
		}

		// Ensure that the sender has permission to use the command before execution
		// `testPermission` has the side effect of sending a message to the sender if they don't have permission, so we don't need to check that here.
		if (!$this->testPermission($sender)) {
			return false;
		}

		$value = $this->onExecute($sender, $arguments);
		// If the return value is a string, we can assume they want to send the sender a message
		if (is_string($value)) {
			$sender->sendMessage($value);
			return true;
		}
		return $value;
	}

	/**
	 * @param array<string, mixed> $arguments
	 */
	public abstract function onExecute(CommandSender $sender, array $arguments): bool|string;

	/**
	 * @param array<string> $args
	 */
	protected function findOverload(CommandSender $sender, array $args): ?Overload {
		foreach ($this->overloads as $overload) {
			if ($overload->validate($sender, $args)) {
				return $overload;
			}
		}
		return null;
	}
}