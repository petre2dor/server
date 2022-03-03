<?php

declare(strict_types=1);

/**
 * @copyright 2022 Carl Schwan <carl@carlschwan.eu>
 *
 * @author Carl Schwan <carl@carlschwan.eu>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCP\Profiler;

use OC\AppFramework\Http\Request;
use OCP\AppFramework\Http\Response;
use OCP\DataCollector\IDataCollector;
use OCP\Profiler\IProfile;

/**
 * This interface allows to interact with the built-in Nextcloud profiler.
 */ 
interface IProfiler {
	/**
	 * Add a new data collector to the profiler. This allows to later on
	 * collect all the data from every registered collector.
	 *
	 * @see IDataCollector 
	 */
	public function add(IDataCollector $dataCollector): void;

	/** Load a profile from a response object */
	public function loadProfileFromResponse(Response $response): ?IProfile;

	/** Load a profile from the response token */
	public function loadProfile(string $token): ?IProfile;

	/**
	 * Save a profile on the disk. This allows to later load it again in the
	 * profiler user interface
	 */
	public function saveProfile(IProfile $profile): bool;

	/**
	 * Find a profile from various search parameters
	 */
	public function find(?string $url, ?int $limit, ?string $method, ?string $start, ?string $end, string $statusCode = null): array;

	/**
	 * Get the list of data providers by identifier
	 * @return string[]
	 */
	public function dataProviders(): array;

	/**
	 * Check if the profiler is enabled.
	 *
	 * If it is not enabled, data provider shouldn't be created and
	 * shouldn't collect any data.
	 */
	public function isEnabled(): bool;

	/**
	 * Set if the profiler is enabled.
	 * @see isEnabled
	 */
	public function setEnabled(bool $enabled): void;
}
