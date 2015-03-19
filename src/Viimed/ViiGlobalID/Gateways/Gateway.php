<?php namespace Viimed\ViiGlobalID\Gateways;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\RequestException;
use Viimed\ViimedAPI\Exceptions\ViimedAPIException;

class Gateway {

	const API_VERSION = 'v2';

	protected $http;

	public function __construct(Http $http)
	{
		$this->http = $http;

		$this->route = "api/" . static::API_VERSION . "/";
	}

	public function getRoute($resource)
	{
		return $this->route . trim($resource, '/');
	}

	protected function getResponseBody()
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