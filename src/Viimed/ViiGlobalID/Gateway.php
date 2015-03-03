<?php namespace ViiGlobalID;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\RequestException;

class Gateway {

	const API_VERSION = 'v2';

	protected $http;
	protected $ViiPartnerID;
	protected $ViiPartnerSecret;
	protected $ViiClientID;

	protected $route;
	protected $response;

	public function __construct(Http $http, $ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
	{
		$this->http = $http;
		$this->ViiPartnerID = $ViiPartnerID;
		$this->ViiPartnerSecret = $ViiPartnerSecret;
		$this->ViiClientID = $ViiClientID;

		$this->route = "api/" . static::API_VERSION . "/authtokens";
	}

	public function generateToken($Identifier, $IdentifierID)
	{
		$params = [
			'ViiPartnerID' =>  $this->ViiPartnerID,
			'ViiClientID' => $this->ViiClientID,
			'Identifier' => $Identifier,
			'IdentifierID' => $IdentifierID
		];

		$params['Hash'] = $this->makeHash( $params );

		$request = $this->http->createRequest('POST', $this->route, [
			'body'	=> $params
		]);

		return $this->executeCall( $request )->data;
	}

	protected function makeHash(array $params)
	{
		$url = $this->http->getBaseUrl() . $this->route;

		ksort( $params ); // sort alphabetically

		$fullUrl = empty($params) ? $url : $url . '?' . http_build_query($params);

		return hash_hmac(static::ALGORITHM, $fullUrl, $this->ViiPartnerSecret);
	}


	public function validateToken($Token, $Identifier, $IdentifierID)
	{
		$params = compact('Token', 'Identifier', 'IdentifierID');
		$params['ViiPartnerID'] = $this->ViiPartnerID;
		$params['ViiClientID'] = $this->ViiClientID;

		$request = $this->http->createRequest('GET', $this->route, [
			'query'	=> $params
		]);

		try{
			return $this->executeCall( $request )->data;
		}
		catch(ViimedAPIException $e)
		{
			throw new InvalidTokenException( InvalidTokenException::FAILED );
		}
	}

	public function destroyToken($Token)
	{
		$params = compact('Token');
		$params['ViiPartnerID'] = $this->ViiPartnerID;
		$params['ViiClientID'] = $this->ViiClientID;

		$request = $this->http->createRequest("DELETE", $this->route, [
			'body'	=> $params
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
			$this->response = json_decode($this->http->send( $request )->getBody()->getContents());

			if( $this->response->status === 'error')
			{
				throw new ViimedAPIException($this->response->errors->message);
			}

			return $this->response;
		}
		catch(RequestException $e) // Catch guzzle exception
		{
			throw new ViimedAPIException($e->getMessage(), $e->getCode(), $e);
		}
	}

}