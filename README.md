[![Build Status](https://travis-ci.org/fliglio/vault.svg?branch=master)](https://travis-ci.org/fliglio/vault)
[![Latest Stable Version](https://poser.pugx.org/fliglio/vault/v/stable.svg)](https://packagist.org/packages/fliglio/vault)

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

The default client will leverage the environment variables `VAULT_ADDR` and `VAULT_TOKEN`

	export VAULT_ADDR=http://localhost:8200
	export VAULT_TOKEN=horde

### Read and Write Secrets

	$secrets = [
		"foo" => "bar",
		"baz" => "boo",
	];

	$c = new Client();

	$resp = $c->write('secret/testing', $secrets);
	$found = $c->read('secret/testing');

	print_r($found['data']);
	
	// Array                                                                                                              │2017/04/14 10:51:31.039926 [ERROR] sys: enable auth mount failed: path=approle/ error=path is already in use
	// (                                                                                                                      │^C==> Vault shutdown triggered
	//     [baz] => boo                                                                                                       │2017/04/14 10:51:34.670329 [INFO ] core: pre-seal teardown starting
	//     [foo] => bar                                                                                                       │2017/04/14 10:51:34.670344 [INFO ] core: cluster listeners not running
	// )

### Login with AppRole
	
	$roleId = "...";
	$secretId = "...";
	$secrets = [
		"foo" => "bar",
		"baz" => "boo",
	];

	$c = new Client(new DefaultConfigFactory([
		'auth' => new AppRole($roleId, $secretId),
	]));

	$resp = $c->write('secret/testing', $secrets);
	$found = $c->read('secret/testing');

	print_r($found['data']);

	// Array                                                                                                              │2017/04/14 10:51:31.039926 [ERROR] sys: enable auth mount failed: path=approle/ error=path is already in use
	// (                                                                                                                      │^C==> Vault shutdown triggered
	//     [baz] => boo                                                                                                       │2017/04/14 10:51:34.670329 [INFO ] core: pre-seal teardown starting
	//     [foo] => bar                                                                                                       │2017/04/14 10:51:34.670344 [INFO ] core: cluster listeners not running
	// )

