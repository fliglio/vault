<?php
namespace Fliglio\Vault\Auth;

use Fliglio\Vault\Client;

class AppRole implements Auth {

	private $roleId;
	private $secretId;

	private $token = null;

	public function __construct($roleId, $secretId) {
		$this->roleId = $roleId;
		$this->secretId = $secretId;
	}

	public function getToken(Client $c) {
		if (is_null($this->token)) {
			$this->token = ''; // update from null to empty string to prevent recursion
			$this->login($c);
		}
		return $this->token;
	}

	private function login(Client $c) {
		$data = $c->write("auth/approle/login", [
			"role_id" => $this->roleId,
			"secret_id" => $this->secretId,
		]);

		$this->token = $data['auth']['client_token'];
	}
}
