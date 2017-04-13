<?php
namespace Fliglio\Vault;

class Client {

	private $addr;
	private $http;
	private $token;

	public function __construct(Config $cfg=null) {
		if (is_null($cfg)) {
			$cfg = new DefaultConfig();
		}
		$this->addr = $cfg->getAddress();
		$this->http = $cfg->getHttpClient();
		$this->token = $cfg->getToken();
	}

	public function login(Auth $auth) {
		$this->token = $auth->login($this);
	}

	public function read($path) {
		$opts = [
			'headers' => [
				'X-VAULT-TOKEN' => $this->token,
			],
		];
		$data = json_decode(
			$this->http->get($this->addr . '/v1/' . $path, $opts)->getBody(),
			true
		);
		return $data;
	}
	public function write($path, $body=[]) {
		$opts = [
			'headers' => [
				'X-VAULT-TOKEN' => $this->token,
			],
			'json' => $body,
		];
		$data = json_decode(
			$this->http->post($this->addr . '/v1/' . $path, $opts)->getBody(),
			true
		);
		return $data;
	}
}
