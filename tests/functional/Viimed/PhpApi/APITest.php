<?php namespace Viimed\PhpApi;


class APITest extends \Codeception\TestCase\Test
{
	/**
	 * @var \FunctionalTester
	 */
	protected $tester;

	protected $_manager;

	protected function _before()
	{
		$this->_manager = API::connect('VIIMED_1', '39dc4799819eb3632e3e20d72955d14f', 'DEVELOPR', 'GetWellUser', 42);
	}

	public function testFactoryGivesInstanceOfGateway()
	{
	   $this->assertInstanceOf('Viimed\\PhpApi\\GatewayManager', $this->_manager);
	}

	public function testGettingAToken()
	{
		$token = $this->_manager->authServices()->generateToken('GetWellUser', 42);

		$this->assertEquals(32, strlen($token));
	}

	// public function testItAppendsCredentialsToQuerys()
	// {
	// 	$globalUsers = $this->_manager->globalUsers()->getAll(1);

	// 	dd( $globalUsers );
	// }

}