<?php
namespace Fliglio\Vault\Auth;

use Fliglio\Vault\Client;

class Tokens implements Auth {

	private $token;

	public function __construct($token) {
		$this->token = $token;
	}

	public function getToken(Client $c) {
		return $this->token;
	}
}
