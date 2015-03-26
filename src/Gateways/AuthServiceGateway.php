<?php namespace Viimed\PhpApi\Gateways;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Message\RequestInterface;
use Viimed\Contracts\Services\SignatureInterface;
use Viimed\Contracts\Services\AuthServiceInterface;
use Viimed\PhpApi\Exceptions\RequestException;
use Viimed\PhpApi\Exceptions\InvalidTokenException;

class AuthServiceGateway extends Gateway implements AuthServiceInterface {

	const ALGORITHM = 'sha1';
	const DATE_KEY = 'X-VII-DATE';
	const DATE_FORMAT = 'Ymd\THis\Z';

	protected $hasher;
	protected $ViiPartnerID;
	protected $ViiPartnerSecret;
	protected $ViiClientID;

	public function __construct(Http $http, SignatureInterface $hasher)
	{
		parent::__construct($http);
		$this->hasher = $hasher;
	}

	public function setCredentials($ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
	{
		$this->ViiPartnerID = $ViiPartnerID;
		$this->ViiPartnerSecret = $ViiPartnerSecret;
		$this->ViiClientID = $ViiClientID;

		return $this;
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

		$url = rtrim($this->http->getBaseUrl(), '/') . "/" .  $this->getRoute("authtokens");
		$params['Hash'] = $this->hasher->makeHash($this->ViiPartnerSecret, $url, $params );

		$request = $this->http->createRequest('POST', $this->getRoute("authtokens"), [
			'body'	=> $params
		]);

		return $this->executeCall( $request )->data;
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

		return $this->executeCall( $request )->data;
	}

}