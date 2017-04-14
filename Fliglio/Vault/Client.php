<?php
namespace Fliglio\Vault;

use GuzzleHttp\Exception\RequestException;

class Client {

	private $addr;
	private $http;
	private $auth;

	public function __construct(ConfigFactory $f = null) {
		if (is_null($f)) {
			$f = new DefaultConfigFactory();
		}
		$this->configure($f->getConfig());
	}
	private function configure(Config $cfg) {
		$this->addr = $cfg->getAddr();
		$this->http = $cfg->getHttp();
		$this->auth = $cfg->getAuth();
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
		$request = $this->http->createRequest($method, $this->addr . '/v1/' . $path, $opts);
		$data;
		try {

			$response = $this->http->send($request);
			$data = json_decode($response->getBody(), true);

		} catch (RequestException $e) {
			$response = $e->getResponse();
			$data = json_decode($response->getBody(), true);
			throw new \Exception(implode($data['errors'], "\n"));
		}
		return $data;
	}
}
