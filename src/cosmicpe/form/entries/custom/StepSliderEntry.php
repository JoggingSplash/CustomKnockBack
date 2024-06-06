<?php

/*
 * JuqnGOOD mi dios.
 */

declare(strict_types=1);

namespace cosmicpe\form\entries\custom;

use ArgumentCountError;
use cosmicpe\form\entries\ModifiableEntry;
use InvalidArgumentException;
use function array_values;
use function count;
use function is_int;

final class StepSliderEntry implements CustomFormEntry, ModifiableEntry {

	private string $title;

	private array $steps;

	private int $default = 0;

	public function __construct(string $title, array $steps) {
		$this->title = $title;
		$this->steps = array_values($steps);
	}

	public function getValue() : string {
		return $this->steps[$this->default];
	}

	public function setValue($value) : void {
		$this->setDefault($value);
	}

	public function setDefault(string $default_step) : void {
		foreach ($this->steps as $index => $step) {
			if ($step === $default_step) {
				$this->default = $index;
				return;
			}
		}

		throw new ArgumentCountError("Step \"" . $default_step . "\" does not exist!");
	}

	public function validateUserInput(mixed $input) : void {
		if (!is_int($input) || $input < 0 || $input >= count($this->steps)) {
			throw new InvalidArgumentException("Failed to process invalid user input: " . $input);
		}
	}

	public function jsonSerialize() : array {
		return [
			"type" => "step_slider",
			"text" => $this->title,
			"steps" => $this->steps,
			"default" => $this->default
		];
	}
}
