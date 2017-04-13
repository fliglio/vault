<?php
namespace Fliglio\Vault;

class DefaultConfig extends Config {

	public function __construct() {
		parent::__construct(getenv('VAULT_ADDR'), new \GuzzleHttp\Client(), getenv('VAULT_TOKEN'));
	}


}
