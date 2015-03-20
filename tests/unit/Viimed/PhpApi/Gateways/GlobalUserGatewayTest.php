<?php namespace Viimed\PhpApi\Gateways;

use Mockery;

class GlobalUserGatewayTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $gateway;

	protected function _before()
	{
		$http = $this->tester->makeHttp();
		$this->gateway = new GlobalUserGateway($http);
	}

	protected function _after()
	{
		Mockery::close();
	}

	// tests
	public function testItImplementsGlobalUserInterface()
	{
		$this->assertInstanceOf('Viimed\\PhpApi\\Interfaces\\GlobalUserInterface', $this->gateway);
	}

	public function testFindById()
	{
		$route = 'api/v2/globalusers/1';
		$params = [];
		$returnData = TRUE;

		$http = $this->tester->mockHttpWithRequest('GET', $route, $params, $returnData);
		
		$bool = (new GlobalUserGateway($http))->findById(1);
		$this->assertTrue( $bool );
	}

	public function testGetExternalIDs()
	{
		$route = 'api/v2/globalusers/1';
		$params = [];
		$returnData = [
			'externalIDs' => TRUE
		];

		$http = $this->tester->mockHttpWithRequest('GET', $route, $params, $returnData);
		
		$bool = (new GlobalUserGateway($http))->getExternalIDs(1);
		$this->assertTrue( $bool );
	}

	public function testFindExternalIDValue()
	{
		$globaluser_id = 1;
		$route = "api/v2/globalusers/$globaluser_id";
		$params = [];
		$returnData = [
			'externalIDs' => [
				[
					'source_name' => "one",
					'value' => 1
				],
				[
					'source_name' => "two",
					'value' => 2
				]
			]
		];

		$http = $this->tester->mockHttpWithRequest('GET', $route, $params, $returnData);
		
		$idValue = (new GlobalUserGateway($http))->findExternalIDValue($globaluser_id, "two");
		$this->assertEquals(2, $idValue);
	}

}