<?php namespace Viimed\PhpApi;


class APITest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before()
	{
	}

	// tests
	public function testGettingConfiguration()
	{
		$config = API::getConfig();

		$this->assertTrue( is_array($config) );
		$this->assertTrue( isset($config['base_urls']));
	}

	public function testConnectReturnsGatewayManager()
	{
		$config = API::getConfig();
		$gateway = API::connect($config['credentials']['ViiPartnerID'], md5('viimed'), $config['credentials']['ViiClientID']);

		$this->assertInstanceOf('Viimed\\PhpApi\\GatewayManager', $gateway);
	}

}