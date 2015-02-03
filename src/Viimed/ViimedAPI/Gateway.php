<?php namespace Viimed\ViimedAPI;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\RequestException;
use Viimed\ViimedAPI\Interfaces\AuthServiceInterface;
use Viimed\ViimedAPI\Interfaces\GatewayInterface;

class Gateway implements GatewayInterface, AuthServiceInterface {

	protected $http;
	protected $ViiPartnerID;
	protected $ViiPartnerSecret;
	protected $ViiClientID;

	protected $response;

	public function __construct(Http $http, $ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
	{
		$this->http = $http;
		$this->ViiPartnerID = $ViiPartnerID;
		$this->$ViiPartnerSecret = $ViiPartnerSecret;
		$this->$ViiClientID = $ViiClientID;
	}

	public function generateToken($Identifier, $IdentifierID)
	{
		$params = [
			'ViiPartnerID' =>  $this->ViiPartnerID,
			'ViiClientID' => $this->ViiClientID,
			'Identifier' => $Identifier,
			'IdentifierID' => $IdentifierID,
			'Hash' => $this->makeHash();
		];

		$request = $this->http->createRequest('POST', '/authtokens', [
			'body'	=> $params
		]);

		return $this->executeCall( $request );
	}


	public function validateToken($Token, $Identifier, $IdentifierID)
	{
		$params = compact('Token', 'Identifier', 'IdentifierID');

		$request = $this->http->createRequest('GET', '/authtokens', [
			'query'	=> $params
		]);

		return $this->executeCall( $request );
	}

	public function destroyToken($Token)
	{
		$params = compact('Token');

		$request = $this->http->createRequest("DELETE", '/authtokens', [
			'query'	=> $params
		]);

		return $this->executeCall( $request );
	}

	public function getResponseBody()
	{
		return $this->response;
	}

	protected function executeCall($request)
	{
		try
		{
			$this->response = $this->http->send( $request )->getBody();

			return $this->response->getContents();
		}
		catch(RequestException $e) // Catch guzzle exception
		{
			throw new ViimedAPIException($e->getMessage(), $e->getCode(), $e);
		}
	}

}