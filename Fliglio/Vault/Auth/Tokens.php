<?php
namespace Fliglio\Vault\Auth;

use Fliglio\Vault\VaultClient;

class Tokens implements Auth {

	private $token;

	public function __construct($token) {
		$this->token = $token;
	}

	public function getToken(VaultClient $c) {
		return $this->token;
	}
}
