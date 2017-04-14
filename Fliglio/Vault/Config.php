<?php
namespace Fliglio\Vault;

use Fliglio\Vault\Auth\Auth;

class Config {

	private $addr;
	private $http;
	private $auth;

	public function __construct($addr, $http, Auth $auth=null) {
		$this->addr = $addr;
		$this->http = $http;
		$this->auth = $auth;
	}
	public function getAddr() {
		return $this->addr;
	}
	public function getHttp() {
		return $this->http;
	}
	public function getAuth() {
		return $this->auth;
	}
}
