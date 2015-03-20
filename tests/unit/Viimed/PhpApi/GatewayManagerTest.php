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

	public function mockGateway($shortClassName)
	{
		$http = Mockery::mock('GuzzleHttp\\Client');

		$class = "Viimed\\PhpApi\\Gateways\\$shortClassName";

		return new $class($http);
	}

	public function testMakingIndexName()
	{
		$gateway = $this->mockGateway('EmrGateway');

		$index = GatewayManager::getIndexName($gateway);
		
		$this->assertEquals('emr', $index);
	}

	// tests
	public function testSettingGateway()
	{
		$gateway = $this->mockGateway('EmrGateway');

		$this->manager->setGateway($gateway);

		return $gateway;
	}

	public function testSettingAndGettingGateway()
	{
		$gateways = ['PatientGateway', 'EmrGateway', 'GlobalUserGateway'];

		foreach($gateways as $gatewayName)
		{
			$gateway = $this->mockGateway( $gatewayName );
			$this->manager->setGateway($gateway);
		}

		foreach(['emrs', 'patients', 'globalUsers'] as $method)
		{
			$this->assertInstanceOf('Viimed\\PhpApi\\Gateways\\Gateway', $this->manager->{$method}(), "GatewayManager::$method doesn't exist.");
		}
	}

	public function testRemovingGateway()
	{
		$gateway = $this->testSettingGateway();

		$this->manager->removeGateway('emr');

		$this->setExpectedException('BadMethodCallException');
		$this->manager->emrs();
	}

	public function testSettingDuplicateGateway()
	{
		$this->testSettingGateway();
		$this->setExpectedException('InvalidArgumentException');
		$this->testSettingGateway();
	}

}