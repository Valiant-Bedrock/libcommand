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

abstract class Command extends \pocketmine\command\Command {

	/** @var array<Overload> */
	protected array $overloads = [];

	public function registerOverload(Overload $overload): void {
		$this->overloads[$overload->getName()] = $overload;
 	}

	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array<string> $args
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		$overload = $this->matchArgsToOverload($args);
		if($overload === null) {
			return false;
		}
		return $this->onExecute($sender, $overload->map($args));
	}

	/**
	 * @param CommandSender $sender
	 * @param array<string, mixed> $arguments
	 * @return bool
	 */
	public abstract function onExecute(CommandSender $sender, array $arguments): bool;

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