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

class Overload {

	/**
	 * @param string $name
	 * @param array<Parameter<mixed>> $parameters
	 */
	public function __construct(protected string $name, protected array $parameters) {
		$last = null;
		foreach($this->parameters as $parameter) {
			if($last !== null && $last->isOptional() && !$parameter->isOptional()) {
				throw new InvalidArgumentException("Optional parameters must be last");
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
	 * @param array<string> $args
	 * @return bool
	 */
	public function matches(array $args): bool {
		if(count($args) !== count($this->parameters)) {
			return false;
		}
		foreach($this->parameters as $parameter) {
			if($parameter->getRequiredNumberOfArguments() > count($args) && !$parameter->isOptional()) {
				return false;
			}

			// Get the values and attempt to validate them
			$values = [];
			for($i = 0; $i < $parameter->getRequiredNumberOfArguments(); $i++) {
				$values[] = array_shift($args);
			}

			/** @var string|array<string> $input */
			$input = count($values) === 1 ? $values[0] : $values;
			if(!$parameter->validate($input)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param array<string> $args
	 * @return array<string, mixed>
	 */
	public function map(array $args): array {
		return array_combine(
			keys: array_map(fn(Parameter $parameter) => $parameter->getName(), $this->parameters),
			values: array_map(
				fn(int $key, string $value) => $this->parameters[$key]->parse($value),
				array_keys($this->parameters),
				$args
			)
		);
	}


}