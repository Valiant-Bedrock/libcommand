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
	 */
	public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [], protected array $overloads = []) {
		parent::__construct($name, $description, $usageMessage, $aliases);
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
			$overload = $this->matchArgsToOverload($args);
			if($overload === null) {
				$sender->sendMessage(TextFormat::RED . $sender->getLanguage()->translate(KnownTranslationFactory::commands_generic_usage($this->getUsage())));
				return false;
			}
			/** @var array<string, mixed> $arguments */
			$arguments = $overload->map($args);
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
	 * @param array<string> $args
	 * @return Overload|null
	 */
	protected function matchArgsToOverload(array $args): ?Overload {
		foreach ($this->overloads as $overload) {
			if ($overload->matches($args)) {
				return $overload;
			}
		}
		return null;
	}
}