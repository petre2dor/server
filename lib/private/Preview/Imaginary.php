<?php
/**
 * @copyright Copyright (c) 2020, Nextcloud, GmbH.
 *
 * @author Vincent Petry <vincent@nextcloud.com>
 * @author Carl Schwan <carl@carlschwan.eu>
 *
 * @license AGPL-3.0-or-later
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OC\Preview;

use OCP\Files\File;
use OCP\Http\Client\IClientService;
use OCP\IConfig;
use OCP\IImage;
use Psr\Log\LoggerInterface;

class Imaginary extends ProviderV2 {
	/** @var IConfig */
	private $config;

	/** @var IClientService */
	private $service;

	/** @var LoggerInterface */
	private $logger;

	public function __construct(array $config) {
		parent::__construct($config);
		$this->config = \OC::$server->get(IConfig::class);
		$this->service = \OC::$server->get(IClientService::class);
		$this->logger = \OC::$server->get(LoggerInterface::class);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMimeType(): string {
		return '/image\/.*/';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getThumbnail(File $file, int $maxX, int $maxY): ?IImage {
		$maxSizeForImages = $this->config->getSystemValue('preview_max_filesize_image', 50);
		$size = $file->getSize();
		$this->logger->error('Imaginary preview geration' . $maxX . ' ' . $maxY);

		if ($maxSizeForImages !== -1 && $size > ($maxSizeForImages * 1024 * 1024)) {
			return null;
		}

		$baseUrl = $this->config->getSystemValueString('preview_imaginary_url', 'http://previews_hpb:8088');
		$baseUrl = rtrim($baseUrl, '/');

		// Object store
		$stream = $file->fopen('r');

		$client = $this->service->newClient();
		$response = $client->post(
			$baseUrl . "/fit?width=$maxX&height=$maxY&stripmeta=true&type=jpeg", [
				'stream' => true,
				'content-type' => $file->getMimeType(),
				'body' => $stream,
				'nextcloud' => ['allow_local_address' => true],
			]);

		if ($response->getStatusCode() !== 200) {
			$this->logger->error('Imaginary preview generation failed: ' . json_decode($response->getBody())['message']);
			return null;
		}

		// TODO stream directly the response to the object store instead of
		// first copying it to the local temp storage
		$image = new \OC_Image();
		$image->loadFromFileHandle($response->getBody());
		if ($image->valid()) {
			$end = microtime(true);
			return $image;
		}

		return null;
	}
}
