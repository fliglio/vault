<?php
namespace Fliglio\Vault;

class Config {

	private $addr;
	private $httpClient;
	private $token;

	public function __construct($addr, $httpClient, $token=null) {
		$this->addr = $addr;
		$this->httpClient = $httpClient;
		$this->token = $token;
	}
	public function getAddress() {
		return $this->addr;
	}
	public function getHttpClient() {
		return $this->httpClient;
	}
	public function getToken() {
		return $this->token;
	}
}
