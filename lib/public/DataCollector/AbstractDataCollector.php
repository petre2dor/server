<?php
// SPDX-FileCopyrightText: Fabien Potencier <fabien@symfony.com>
// SPDX-License-Identifier: MIT

declare(strict_types=1);

namespace OCP\DataCollector;

/**
 * Children of this class must store the collected data in
 * the data property.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bernhard Schussek <bschussek@symfony.com>
 * @author Carl Schwan <carl@carlschwan.eu>
 */
abstract class AbstractDataCollector implements IDataCollector, \JsonSerializable {
	/** @var array */
	protected $data = [];

	public function getName(): string {
		return static::class;
	}

	/**
	 * Reset the state of the profiler. By default it only empties the
	 * $this->data contents, but you can override this method to do
	 * additional cleaning.
	 */
	public function reset(): void {
		$this->data = [];
	}

	public function __sleep(): array {
		return ['data'];
	}

	/**
	 * @internal to prevent implementing \Serializable
	 */
	final protected function serialize() {
	}

	/**
	 * @internal to prevent implementing \Serializable
	 */
	final protected function unserialize(string $data) {
	}

	public function jsonSerialize() {
		return $this->data;
	}

}
