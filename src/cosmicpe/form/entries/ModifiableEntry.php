<?php

/*
 * JuqnGOOD mi dios.
 */

declare(strict_types=1);

namespace cosmicpe\form\entries;

use InvalidArgumentException;

interface ModifiableEntry {

	public function getValue();

	public function setValue($value) : void;

	/**
	 * @throws InvalidArgumentException
	 */
	public function validateUserInput(mixed $input) : void;
}
