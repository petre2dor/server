<?php

namespace OCA\User_LDAP\DataCollector;

use OC\AppFramework\Http\Request;
use OCP\AppFramework\Http\Response;
use OCP\DataCollector\AbstractDataCollector;

class LdapDataCollector extends AbstractDataCollector {
	public function startLdapRequest(string $query, array $args): void {
		$this->data[] = [
			'start' => microtime(true),
			'query' => $query,
			'args' => $args,
			'end' => -1
		];
	}

	public function stopLastLdapRequest(): void {
		$this->data[count($this->data) - 1]['end'] = microtime(true);
	}

	public function getName(): string {
		return 'ldap';
	}

	public function collect(Request $request, Response $response, \Throwable $exception = null): void {
	}
}
