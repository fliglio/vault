<?php
namespace Fliglio\Vault;

interface Auth {
	public function login(Client $c);
}
