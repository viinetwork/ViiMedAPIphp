<?php namespace Viimed\ViimedAPI;

use Viimed\ViimedAPI\Exceptions\InvalidTokenException;

abstract class ViimedTest extends \Codeception\TestCase\Test {

	/**
	 * @var \FunctionalTester
	 */
	protected $tester;

	protected $gateway;

	protected function _before()
	{
		// Instantiate Object
		$this->gateway = Viimed::connect('VIIMED_1', '39dc4799819eb3632e3e20d72955d14f', 'DEVELOPR');
	}

	public function testFactoryGivesInstanceOfGateway()
	{
	   $this->assertInstanceOf('Viimed\\ViimedAPI\\Gateway', $this->gateway);
	}

	public function testAuthServiceInterface()
	{
		$Identifier = 'GetWellUser';
		$IdentifierID = 42;

		// Make Token
		$token = $this->gateway->generateToken($Identifier, $IdentifierID);
		$this->assertEquals(32, strlen($token));

		// Validate Token
		$bool = $this->gateway->validateToken($token, $Identifier, $IdentifierID);
		$this->assertTrue($bool);

		// Destroy Token
		$this->gateway->destroyToken( $token );

		// Validate Invalid Token
		$this->setExpectedException('Viimed\\ViimedAPI\\Exceptions\\InvalidTokenException', InvalidTokenException::FAILED);
		$this->gateway->validateToken($token, $Identifier, $IdentifierID);
	}

}