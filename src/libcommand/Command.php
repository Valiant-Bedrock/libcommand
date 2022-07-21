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

abstract class Command extends \pocketmine\command\Command {

	/**
	 * @param string $name
	 * @param Translatable|string $description
	 * @param Translatable|string|null $usageMessage
	 * @param array<string> $aliases
	 * @param array<Overload> $overloads
	 * @param string|null $permission
	 * @param string|null $permissionMessage
	 */
	public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [], protected array $overloads = [], ?string $permission = null, ?string $permissionMessage = null) {
		parent::__construct($name, $description, $usageMessage, $aliases);
		if ($permission !== null) {
			$this->setPermission($permission);
			assert($permissionMessage !== null, "Permission message cannot be null if permission is set.");
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
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array<string> $args
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		$arguments = [];
		if(count($this->overloads) > 0) {
			$overload = $this->findOverload($sender, $args);
			if($overload === null) {
				$sender->sendMessage(TextFormat::RED . $sender->getLanguage()->translate(KnownTranslationFactory::commands_generic_usage($this->getUsage())));
				return false;
			}
			$arguments = $overload->map($sender, $args);
		}
		$value = $this->onExecute($sender, $arguments);
		if(is_string($value)) {
			$sender->sendMessage($value);
			return true;
		}
		return $value;
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string, mixed> $arguments
	 * @return bool|string
	 */
	public abstract function onExecute(CommandSender $sender, array $arguments): bool|string;

	/**
	 * @param CommandSender $sender
	 * @param array<string> $args
	 * @return Overload|null
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