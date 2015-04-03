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
		$this->_manager = $this->tester->getAPI();
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

	public function testVerifingToken()
	{
		$token = $this->_manager->authServices()->generateToken('GetWellUser', 42);

		$bool = $this->_manager->authServices()->validateToken($token, 'GetWellUser', 42);

		$this->assertTrue($bool);
	}

	// public function testItAppendsCredentialsToQuerys()
	// {
	// 	$globalUsers = $this->_manager->globalUsers()->getAll(1);

	// 	dd( $globalUsers );
	// }

}