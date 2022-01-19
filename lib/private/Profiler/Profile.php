<?php


namespace OC\Profiler;


use OCP\DataCollector\IDataCollector;

class Profile implements \JsonSerializable {
	/** @var string */
	private $token;

	/** @var int */
	private $time;

	/** @var string $url */
	private $url;

	/** @var string $method */
	private $method;

	/** @var int $statusCode */
	private $statusCode;

	/** @var array<string, IDataCollector> */
	private $collectors = [];

	/** @var Profile|null */
	private $parent;

	/** @var Profile[] */
	private $children = [];

	public function __construct(string $token) {
		$this->token = $token;
	}

	public function getToken(): string {
		return $this->token;
	}

	public function setToken(string $token): void {
		$this->token = $token;
	}

	public function getTime(): int {
		return $this->time;
	}

	public function setTime(int $time): void {
		$this->time = $time;
	}

	public function getUrl(): string {
		return $this->url;
	}

	public function setUrl(string $url): void {
		$this->url = $url;
	}

	public function getMethod(): string {
		return $this->method;
	}

	public function setMethod(string $method): void {
		$this->method = $method;
	}

	public function getStatusCode(): int {
		return $this->statusCode;
	}

	public function setStatusCode(int $statusCode): void {
		$this->statusCode = $statusCode;
	}

	public function addCollector(IDataCollector $collector) {
		$this->collectors[$collector->getName()] = $collector;
	}

	public function getParent(): ?Profile {
		return $this->parent;
	}

	public function setParent(?Profile $parent): void {
		$this->parent = $parent;
	}

	public function getParentToken(): ?string {
		return $this->parent ? $this->parent->getToken() : null;
	}

	/** @return Profile[] */
	public function getChildren(): array {
		return $this->children;
	}

	/**
	 * @param Profile[] $children
	 */
	public function setChildren(array $children) {
		$this->children = [];
		foreach ($children as $child) {
			$this->addChild($child);
		}
	}

	public function addChild(Profile $profile) {
		$this->children[] = $profile;
		$profile->setParent($this);
	}

	/**
	 * @return IDataCollector[]
	 */
	public function getCollectors(): array
	{
		return $this->collectors;
	}

	/**
	 * @param IDataCollector[] $collectors
	 */
	public function setCollectors(array $collectors): void
	{
		$this->collectors = $collectors;
	}

	public function __sleep(): array {
		return ['token', 'parent', 'children', 'collectors', 'method', 'url', 'time', 'statusCode'];
	}

	public function jsonSerialize() {
		// Everything but parent
		return [
			'token' => $this->token,
			'method' => $this->method,
			'children' => $this->children,
			'url' => $this->url,
			'statusCode' => $this->statusCode,
			'time' => $this->time,
			'collectors' => $this->collectors,
		];
	}
}
