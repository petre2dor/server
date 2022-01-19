<?php
/*
 * SPDX-FileCopyrightText: Fabien Potencier <fabien@symfony.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace OCP\DataCollector;

use OC\AppFramework\Http\Request;
use OCP\AppFramework\Http\Response;

/**
 * DataCollectorInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface IDataCollector {
	/**
	 * Collects data for the given Request and Response.
	 */
	public function collect(Request $request, Response $response, \Throwable $exception = null): void;

	/**
	 * Reset the state of the profiler.
	 */
	public function reset(): void;

	/**
	 * Returns the name of the collector.
	 */
	public function getName(): string;
}
