<?php namespace Viimed\PhpApi;

use Mockery;

class GatewayManagerTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $manager;

	protected function _before()
	{
		$this->manager = new GatewayManager;
	}

	protected function makeGateway()
	{
		$http = Mockery::mock('GuzzleHttp\\Client');

		return new Gateways\EmrGateway($http);
	}

	public function testMakingIndexName()
	{
		$gateway = $this->makeGateway();

		$index = GatewayManager::getIndexName($gateway);
		
		$this->assertEquals('emr', $index);
	}

	// tests
	public function testSettingGateway()
	{
		$gateway = $this->makeGateway();

		$this->manager->setGateway($gateway);

		return $gateway;
	}

	public function testSettingAndGettingGateway()
	{
		$gateway = $this->testSettingGateway();

		$emrGateway = $this->manager->emr();

		$this->assertEquals($gateway, $emrGateway);
	}

	public function testRemovingGateway()
	{
		$gateway = $this->testSettingGateway();

		$this->manager->removeGateway('emr');

		$this->setExpectedException('BadMethodCallException');
		$this->manager->emr();
	}

	public function testSettingDuplicateGateway()
	{
		$this->testSettingGateway();
		$this->setExpectedException('InvalidArgumentException');
		$this->testSettingGateway();
	}

}