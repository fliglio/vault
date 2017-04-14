<?php
namespace Fliglio\Vault\Auth;

use Fliglio\Vault\Client;

interface Auth {
	public function getToken(Client $c);
}
