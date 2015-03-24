<?php namespace Viimed\PhpApi\Gateways;

use BadMethodCallException;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Exception\RequestException;
use Viimed\PhpApi\Exceptions\RequestException as ViimedRequestException;

abstract class Gateway {

	const API_VERSION = 'v2';

	protected static $credentials = [];

	protected $http;
	
	protected $route;

	public function __construct(Http $http)
	{
		$this->http = $http;

		$this->route = "api/" . static::API_VERSION . "/";
	}

	public static function setCredentials(array $credentials)
	{
		static::$credentials = $credentials;
	}

	public static function getCredentials()
	{
		return static::$credentials;
	}

	public function __call($method, $args)
	{
		throw new BadMethodCallException(get_called_class() . "::" . $method . "() does not exist.");
	}

	public function getRoute($resource)
	{
		return rtrim($this->route . trim($resource, '/'), '/');
	}

	public function getResponseBody()
	{
		return $this->response;
	}

	protected function executeCall(RequestInterface $request)
	{
		// Add Token credentials
		// $this->decorateRequestQueryWithCredentials($request);

		try
		{
			$this->response = json_decode($this->http->send( $request )->getBody()->getContents());

			if( $this->response->status === 'error')
			{
				throw new ViimedRequestException($this->response->errors->message);
			}

			return $this->response;
		}
		catch(RequestException $e) // Catch guzzle exception
		{
			throw new ViimedRequestException($e->getMessage(), $e->getCode(), $e);
		}
	}

	protected function decorateRequestQueryWithCredentials(RequestInterface &$request)
	{
		// $query is still referenced and not needed to be passed back
		// see http://guzzle.readthedocs.org/en/latest/http-messages.html
		$query = $request->getQuery();
		foreach(static::$credentials as $key => $value)
		{
			$query[$key] = $value;
		}
	}
}