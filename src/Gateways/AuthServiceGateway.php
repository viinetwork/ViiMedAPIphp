<?php namespace Viimed\PhpApi\Gateways;

use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Interfaces\AuthServiceInterface;
use Viimed\PhpApi\Exceptions\ViimedAPIException;
use Viimed\PhpApi\Exceptions\RequestException;
use Viimed\PhpApi\Exceptions\InvalidTokenException;

class AuthServiceGateway extends Gateway implements AuthServiceInterface {

	const ALGORITHM = 'sha1';
	const DATE_KEY = 'X-VII-DATE';
	const DATE_FORMAT = 'Ymd\THis\Z';

	protected $ViiPartnerID;
	protected $ViiPartnerSecret;
	protected $ViiClientID;

	public function __construct(Http $http, $ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
	{
		parent::__construct($http);
		$this->ViiPartnerID = $ViiPartnerID;
		$this->ViiPartnerSecret = $ViiPartnerSecret;
		$this->ViiClientID = $ViiClientID;
	}

	public function generateToken($Identifier, $IdentifierID)
	{
		$params = [
			'ViiPartnerID' =>  $this->ViiPartnerID,
			'ViiClientID' => $this->ViiClientID,
			'Identifier' => $Identifier,
			'IdentifierID' => $IdentifierID,
			static::DATE_KEY => date(static::DATE_FORMAT)
		];

		$params['Hash'] = $this->makeHash( $params );

		$request = $this->http->createRequest('POST', $this->getRoute("authtokens"), [
			'body'	=> $params
		]);

		return $this->executeCall( $request )->data;
	}

	protected function makeHash(array $params)
	{
		$url = $this->http->getBaseUrl() . $this->getRoute("authtokens");

		ksort( $params ); // sort alphabetically

		$fullUrl = empty($params) ? $url : $url . '?' . http_build_query($params);

		return hash_hmac(static::ALGORITHM, $fullUrl, $this->ViiPartnerSecret);
	}


	public function validateToken($Token, $Identifier, $IdentifierID)
	{
		$params = compact('Token', 'Identifier', 'IdentifierID');
		$params['ViiPartnerID'] = $this->ViiPartnerID;
		$params['ViiClientID'] = $this->ViiClientID;

		$request = $this->http->createRequest('GET', $this->getRoute("authtokens"), [
			'query'	=> $params
		]);

		try{
			return $this->executeCall( $request )->data;
		}
		catch(RequestException $e)
		{
			throw new InvalidTokenException( InvalidTokenException::FAILED );
		}
	}

	public function destroyToken($Token)
	{
		$params = compact('Token');
		$params['ViiPartnerID'] = $this->ViiPartnerID;
		$params['ViiClientID'] = $this->ViiClientID;

		$request = $this->http->createRequest("DELETE", $this->getRoute("authtokens"), [
			'body'	=> $params
		]);

		return $this->executeCall( $request );
	}

}