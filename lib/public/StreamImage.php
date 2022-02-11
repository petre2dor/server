<?php
/**
 * @copyright Copyright (c) 2021 Carl Schwan <carl@carlschwan.eu>
 *
 * @author Carl Schwan <carl@carlschwan.eu>
 *
 * @license AGPL-3.0-or-later
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

namespace OCP;

/**
 * Only useful when dealing with transferring streamed previews from an external
 * service to an object store.
 *
 * Only width/height/resource and mimeType are implemented and will give you a
 * valid result.
 */
class StreamImage implements IStreamImage {
	/** @var resource The internal stream */
	private $stream;

	/** @var string */
	private $mimeType;

	/** @var int */
	private $width;

	/** @var int */
	private $height;

	/** @param resource $stream */
	public function __construct($stream, string $mimeType, int $width, int $height) {
		$this->stream = $stream;
		$this->mimeType = $mimeType;
		$this->width = $width;
		$this->height = $height;
	}

	/** @inheritDoc */
	public function valid() {
		return is_resource($this->stream);
	}

	/** @inheritDoc */
	public function mimeType() {
		return $this->mimeType;
	}

	/** @inheritDoc */
	public function width() {
		return $this->width;
	}

	/** @inheritDoc */
	public function height() {
		return $this->height;
	}

	/** This will return an invalid result */
	public function widthTopLeft() {
		return -1;
	}

	public function heightTopLeft() {
		return -1;
	}

	public function show($mimeType = null) {
		return -1;
	}

	public function save($filePath = null, $mimeType = null) {
		return -1;
	}

	public function resource() {
		return $this->stream;
	}

	public function dataMimeType() {
		return $this->mimeType;
	}

	public function data() {
		return '';
	}

	public function getOrientation() {
		return -1;
	}

	public function fixOrientation() {
		return false;
	}

	public function resize($maxSize) {
		return false;
	}

	public function preciseResize(int $width, int $height): bool {
		return false;
	}

	public function centerCrop($size = 0) {
	}

	public function crop(int $x, int $y, int $w, int $h): bool {
		return false;
	}

	public function fitIn($maxWidth, $maxHeight) {
		return false;
	}

	public function scaleDownToFit($maxWidth, $maxHeight) {
		return false;
	}

	public function copy(): IImage {
		return $this;
	}

	public function cropCopy(int $x, int $y, int $w, int $h): IImage {
		return $this;
	}

	public function preciseResizeCopy(int $width, int $height): IImage {
		return $this;
	}

	public function resizeCopy(int $maxSize): IImage {
		return $this;
	}
}
