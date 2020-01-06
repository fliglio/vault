<?php
namespace Fliglio\Vault;

use GuzzleHttp\Exception\RequestException;

class VaultClient {

	private $addr;
	private $http;
	private $auth;
	private $addrHostName;

	public function __construct(VaultConfigFactory $f = null) {
		if (is_null($f)) {
			$f = new DefaultVaultConfigFactory();
		}
		$this->configure($f->getConfig());
	}
	private function configure(VaultConfig $cfg) {
		$this->addr = $cfg->getAddr();
		$this->http = $cfg->getHttp();
		$this->auth = $cfg->getAuth();
		$this->addrHostName = $cfg->getAddrHostName();
	}

	public function authEnable($type) {
		return $this->write("sys/auth/$type", ["type"=> $type]);
	}
	public function authDisable($type) {
		return $this->makeRequest("DELETE", "sys/auth/$type", ["type"=> $type]);
	}

	public function read($path) {
		return $this->makeRequest('GET', $path);
	}
	public function write($path, $body=[]) {
		return $this->makeRequest('POST', $path, $body);
	}
	private function makeRequest($method, $path, $body=[]) {
		$opts = [
			'headers' => [
				'X-VAULT-TOKEN' => $this->auth->getToken($this),
			],
			'json' => $body,
		];
		if (!is_null($this->addrHostName)) {
			$opts['headers']['Host'] = $this->addrHostName;
		}
		$data = null;
		try {
			$response = null;
			if (method_exists($this->http, 'request')) {
				// Guzzle 6.x
				$response = $this->http->request($method, $this->addr . '/v1/' . $path, $opts);
			} else {
				// Guzzle 5.x
				$request = $this->http->createRequest($method, $this->addr . '/v1/' . $path, $opts);
				$response = $this->http->send($request);
			}

			$data = json_decode($response->getBody(), true);

		} catch (RequestException $e) {
			if (!isset($response)) {
				throw $e;
			}
			$response = $e->getResponse();
			$data = json_decode($response->getBody(), true);
			throw new \Exception(implode($data['errors'], "\n"));
		}
		return $data;
	}
}
