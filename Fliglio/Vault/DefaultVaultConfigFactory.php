<?php
namespace Fliglio\Vault;

use Fliglio\Vault\Auth\Tokens;

class DefaultVaultConfigFactory implements VaultConfigFactory {

	private $addr;
	private $addrHostName;
	private $http;
	private $auth;

	public function __construct($options = []) {
		$this->addr = isset($options['addr']) ? $options['addr'] : getenv('VAULT_ADDR');
		$this->addrHostName = isset($options['addrHostName']) ? $options['addrHostName'] : null;
		$this->http = isset($options['http']) ? $options['http'] : new \GuzzleHttp\Client();
		$this->auth = isset($options['auth']) ? $options['auth'] : null;

		if (is_null($this->auth)) {
			$token = getenv('VAULT_TOKEN');

			if ($token !== false) {
				$this->auth = new Tokens($token);
			}
		}
	}

	public function getConfig() {
		return new VaultConfig($this->addr, $this->http, $this->auth, $this->addrHostName);
	}

}
