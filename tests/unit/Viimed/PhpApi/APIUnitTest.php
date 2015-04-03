<?php namespace Viimed\PhpApi;


class APIUnitTest extends \Codeception\TestCase\Test
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
		$this->assertTrue( isset($config['viiid']));
	}

	// public function testConnectReturnsGatewayManager()
	// {
	// 	$config = API::getConfig();
	// 	$gateway = API::connect('ViiPartnerID', md5('some_secret'), 'ViiClientID', 'Identifier', 'IdentifierID');

	// 	$this->assertInstanceOf('Viimed\\PhpApi\\GatewayManager', $gateway);
	// }

}