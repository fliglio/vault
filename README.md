[![Build Status](https://travis-ci.org/fliglio/vault.svg?branch=master)](https://travis-ci.org/fliglio/vault)

# Vault SDK

Supports:

- auth
	- tokens
	- authrole
- general
	- read
	- write


## Examples

### Configure Environment

	export VAULT_ADDR=http://localhost:8200
	export VAULT_TOKEN=horde

### Read and Write Secrets

	$c = new Client();

	$resp = $c->write('secret/testing', $secrets);
	$found = $c->read('secret/testing');

### Login with auth role
	
	$roleId = "...";
	$secretId = "...";

	$c = new Client(new DefaultConfigFactory([
		'auth' => new AppRole($roleId, $secretId),
	]));

	$resp = $c->write('secret/testing', $secrets);
	$found = $c->read('secret/testing');
