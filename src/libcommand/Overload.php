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

use InvalidArgumentException;
use libcommand\parameter\Parameter;
use libcommand\parameter\types\RawTextParameter;
use pocketmine\command\CommandSender;

class Overload {

	/**
	 * @param string $name
	 * @param array<Parameter<mixed>> $parameters
	 */
	public function __construct(protected string $name, protected array $parameters) {
		$last = null;
		foreach($this->parameters as $parameter) {
			if($last !== null && $last->isOptional() && !$parameter->isOptional()) {
				throw new InvalidArgumentException("Optional parameters must not be followed by required parameters");
			} elseif($last instanceof RawTextParameter) {
				throw new InvalidArgumentException("Raw text parameters must be last");
			}
			$last = $parameter;
		}
	}

	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return array<Parameter<mixed>>
	 */
	public function getParameters(): array {
		return $this->parameters;
	}

	/**
	 * @return array<Parameter<mixed>>
	 */
	public function getRequiredParameters(): array {
		return array_filter(
			array: $this->parameters,
			callback: fn(Parameter $parameter) => !$parameter->isOptional()
		);
	}

	/**
	 * Attempts to validate the arguments provided by the sender to find a match.
	 *
	 * @param CommandSender $sender
	 * @param array<string> $args
	 * @return bool
	 */
	public function validate(CommandSender $sender, array $args): bool {
		// If there are less args than required parameters, we can assume that this overload is not a match
		if(count($args) < count($this->getRequiredParameters())) {
			return false;
		}
		foreach($this->parameters as $parameter) {
			// Validate parameter
			if(!$parameter->validate($sender, $args) && !$parameter->isOptional()) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Parses the arguments and maps them to a map of values
	 *
	 * @param CommandSender $sender
	 * @param array<string> $args
	 * @return array<string, mixed>
	 */
	public function map(CommandSender $sender, array &$args): array {
		$output = [];
		foreach($this->parameters as $parameter) {
			if(count($args) <= 0) {
				// If there are no more arguments, we can break and return the output
				break;
			}
			$output[$parameter->getName()] = $parameter->parse($sender, $args);
		}
		return $output;
	}


}