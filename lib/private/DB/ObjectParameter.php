<?php
<<<<<<< Updated upstream


namespace OC\DB;


class ObjectParameter
{

=======
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OC\DB;

final class ObjectParameter
{
	/** @var object  */
	private $object;

	/** @var \Throwable|null */
	private $error;

	/** @var bool  */
	private $stringable;

	/** @var string */
	private $class;

	public function __construct(object $object, ?\Throwable $error) {
		$this->object = $object;
		$this->error = $error;
		$this->stringable = \is_callable([$object, '__toString']);
		$this->class = \get_class($object);
	}

	public function getObject(): object {
		return $this->object;
	}

	public function getError(): ?\Throwable {
		return $this->error;
	}

	public function isStringable(): bool {
		return $this->stringable;
	}

	public function getClass(): string {
		return $this->class;
	}
>>>>>>> Stashed changes
}
