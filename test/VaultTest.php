<?php

namespace Fliglio\Vault;


class VaultTest extends \PHPUnit_Framework_TestCase {

	public function testDefaultConfig() {
		$cfg = new DefaultConfig();

		$this->assertEquals($cfg->getAddress(), "http://localhost:8200");
		$this->assertEquals(get_class($cfg->getHttpClient()), "GuzzleHttp\Client");
		$this->assertEquals($cfg->getToken(), "horde");
	}

//	public function testLogin() {
//		$c = new Client();
//		$c->login(new AppRoleAuth($roleId, $secretId));
//	}

	public function testSecrets() {
		// given
		$secrets = [
			"foo" => "bar",
			"baz" => "boo",
		];
		
		// when
		$c = new Client();

		$resp = $c->write('secret/testing', $secrets);
		$found = $c->read('secret/testing');
		
		// then
		$this->assertEquals($secrets, $found['data'], "read secrets should match written secrets");
	}
}
