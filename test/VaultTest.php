<?php

namespace Fliglio\Vault;


use Fliglio\Vault\Auth\AppRole;

class VaultTest extends \PHPUnit_Framework_TestCase {
	
	private $pid;

	public function setup() {

		$cmd = "vault server -dev -dev-root-token-id=horde";
		exec(sprintf("%s >/dev/null 2>&1 & echo $!", $cmd), $out);

		$this->pid = $out[0];
		usleep(100000);
	}

	public function teardown() {
		posix_kill(intval($this->pid), 9);
	}

	public function testDefaultConfig() {
		$cfg = (new DefaultConfigFactory())->getConfig();

		$this->assertEquals($cfg->getAddr(), "http://localhost:8200");
		$this->assertEquals(get_class($cfg->getHttp()), "GuzzleHttp\Client");
		$this->assertEquals(get_class($cfg->getAuth()), "Fliglio\Vault\Auth\Tokens");
		$this->assertEquals($cfg->getAuth()->getToken(new Client()), "horde");
	}

	public function testAppRoleAuth() {
		$c = new Client();
		$resp = $c->authDisable('approle');
		$resp = $c->authEnable('approle');
		$resp = $c->authDisable('approle');
		$resp = $c->authEnable('approle');
	}
	/**
	 * @expectedException \Exception
	 */
	public function testAppRoleAuthExists() {
		$c = new Client();
		$resp = $c->authEnable('approle');
		$resp = $c->authEnable('approle');
	}

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
