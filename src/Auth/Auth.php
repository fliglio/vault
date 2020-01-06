<?php
namespace Fliglio\Vault\Auth;

use Fliglio\Vault\VaultClient;

interface Auth {
	public function getToken(VaultClient $c);
}
