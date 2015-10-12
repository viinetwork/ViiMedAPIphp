<?php namespace Viimed\PhpApi\Gateways;

use Exception;
use BadMethodCallException;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Exception\RequestException;
use Viimed\PhpApi\Exceptions\RequestException as ViimedRequestException;

abstract class Gateway {

	protected $http;

	public function __construct(Http $http)
	{
		$this->http = $http;
	}

	public function __call($method, $args)
	{
		throw new BadMethodCallException(get_called_class() . "::" . $method . "() does not exist.");
	}

	public function getRoute($resource = '')
	{
		$baseUrl = rtrim($this->http->getBaseUrl(), '/');

		$resource = trim($resource, '/');

		if( $resource === '' )
			return $baseUrl;

		return $baseUrl . '/' . $resource;
	}

	public function getResponseBody()
	{
		return $this->response;
	}

	public function getMetaArray()
	{
		return $this->getResponseBody()->meta;
	}

	public static function decorateParams(array &$params, $limit, $offset)
	{
		if( ! is_null($limit) || ! is_null($offset))
		{
			if( ! isset($params['query'])) $params['query'] = [];
			if( ! is_null($limit)) $params['query']['limit'] = $limit;
			if( ! is_null($offset)) $params['query']['offset'] = $offset;
		}
	}

	protected function executeCall(RequestInterface $request, $expectJson = true)
	{
		// quick fix to get the domain into a header. sorry Aaron.
		if ($site = \RequestLogger::$site) {
			$domain = $site->domain;
		} else {
			$domain = $_SERVER['HTTP_HOST'];
			$domain = preg_replace('/:\d+$/', '', $domain);
		}
		$request->addHeader('X-DOMAIN', $domain);

		try {
			$this->response = $this->http->send( $request )->getBody()->getContents();

			if ($expectJson) {
				$this->response = json_decode($this->response);

				if (property_exists($this->response, 'status') && $this->response->status === 'error') {
					throw new ViimedRequestException($this->response->errors->message);
				}
			}

			return $this->response;
		} catch(RequestException $e) {
			// Catch guzzle exception
			throw new ViimedRequestException($e->getMessage(), $e->getCode(), $e);
		} catch(Exception $e) {
			// Catch anything else
			throw new ViimedRequestException($e->getMessage(), $e->getCode(), $e);
		}
	}

}
