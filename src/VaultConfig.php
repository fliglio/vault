<?php
namespace Fliglio\Vault;

use Fliglio\Vault\Auth\Auth;

class VaultConfig {

	private $addr;
	private $http;
	private $auth;
	private $addrHostName;

	public function __construct($addr, $http, Auth $auth=null, $addrHostName=null) {
		$this->addr = $addr;
		$this->http = $http;
		$this->auth = $auth;
		$this->addrHostName = $addrHostName;
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
	public function getAddrHostName() {
		return $this->addrHostName;
	}
}
