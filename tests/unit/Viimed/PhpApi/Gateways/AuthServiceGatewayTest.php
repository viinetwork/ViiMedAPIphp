<?php namespace Viimed\PhpApi\Gateways;

use Mockery;
use Viimed\Contracts\Services\SignatureInterface;

class AuthServiceGatewayTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected $gateway;

	protected $ViiPartnerID;
	protected $ViiPartnerSecret;
	protected $ViiClientID;

	protected function _before()
	{
		$this->ViiPartnerID = 'VIIMED_1';
		$this->ViiPartnerSecret = md5('viimed');
		$this->ViiClientID = 'DEVELOPR';

		$http = $this->tester->makeHttp();
		$signature = $this->tester->mockSignature(NULL);
		$this->gateway = new AuthServiceGateway($http, $signature);
		$this->gateway->setCredentials($this->ViiPartnerID, $this->ViiPartnerSecret, $this->ViiClientID);
	}

	protected function makeGateway($http, SignatureInterface $sig)
	{
		$gateway = new AuthServiceGateway($http, $sig);
		
		$gateway->setCredentials($this->ViiPartnerID, $this->ViiPartnerSecret, $this->ViiClientID);

		return $gateway;
	}

	protected function _after()
	{
		Mockery::close();
	}

	// tests
	public function testItImplementsAuthServiceInterface()
	{
		$this->assertInstanceOf('Viimed\\Contracts\\Services\\AuthServiceInterface', $this->gateway);
	}

	public function testGenerateToken()
	{
		$Identifier = 'User';
		$IdentifierID = 42;
		$route = 'http://localhost/api/v2/authtokens';
		$returnData = "myHash";
		$params = [
			'body' => [
				'ViiPartnerID' =>  $this->ViiPartnerID,
				'ViiClientID' => $this->ViiClientID,
				'Identifier' => $Identifier,
				'IdentifierID' => $IdentifierID,
				AuthServiceGateway::DATE_KEY => date(AuthServiceGateway::DATE_FORMAT),
				'Hash' => $returnData
			]
		];

		$http = $this->tester->mockHttpWithRequest('POST', $route, $params, $returnData);
		$http->shouldReceive('getBaseUrl')->andReturn($route);

		$sig = $this->tester->mockSignature($returnData);

		$gateway = $this->makeGateway($http, $sig);

		$token = $gateway->generateToken($Identifier, $IdentifierID);

		$this->assertEquals($returnData, $token);
	}

	public function testValidateToken()
	{
		$Identifier = 'User';
		$IdentifierID = 42;
		$route = 'http://localhost/api/v2/authtokens';
		$returnData = TRUE;
		$Token = "1234";
		$params = [
			'query' => [
				'ViiPartnerID' =>  $this->ViiPartnerID,
				'ViiClientID' => $this->ViiClientID,
				'Identifier' => $Identifier,
				'IdentifierID' => $IdentifierID,
				'Token' => $Token
			]
		];

		$http = $this->tester->mockHttpWithRequest('GET', $route, $params, $returnData);

		$sig = $this->tester->mockSignature(NULL);

		$gateway = $this->makeGateway($http, $sig);

		$result = $gateway->validateToken($Token, $Identifier, $IdentifierID);

		$this->assertEquals($returnData, $result);
	}

	public function testDestroyToken()
	{
		$route = 'api/v2/authtokens';
		$returnData = TRUE;
		$Token = "1234";
		$params = [
			'body' => [
				'ViiPartnerID' =>  $this->ViiPartnerID,
				'ViiClientID' => $this->ViiClientID,
				'Token' => $Token
			]
		];

		$http = $this->tester->mockHttpWithRequest('DELETE', $route, $params, $returnData);

		$sig = $this->tester->mockSignature(NULL);

		$gateway = $this->makeGateway($http, $sig);

		$result = $gateway->destroyToken($Token);

		$this->assertEquals($returnData, $result);
	}

}