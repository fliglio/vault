<?php
namespace Fliglio\Vault;

class AppRoleAuth implements Auth {

	private $roleId;
	private $secretId;

	public function __construct($roleId, $secretId) {
		$this->roleId = $roleId;
		$this->secretId = $secretId;
	}

	public function login(Client $c) {
		$data = $c->write("auth/approle/login", [
			"role_id" => $this->roleId,
			"secret_id" => $this->secret_id,
		]);

		return $data['auth']['client_token'];
	}
}
