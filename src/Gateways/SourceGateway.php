<?php namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Exceptions\RequestException;

class SourceGateway extends Gateway  {

	public function findById($sourceId)
	{
		$params = [];
		$route = $this->getRoute("sources/{$sourceId}");

		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}

	public function getAll($limit = NULL, $offset = NULL)
	{
		$params = [];
		$route = $this->getRoute("sources");

		static::decorateParams($params, $limit, $offset);

		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}

	public function findSourceByName($name)
	{
		$sources = $this->getSourcesWithNameLike($name);

		if( count($sources) != 1)
		{
			throw new RequestException("Source not found.");
		}

		return current($sources);
	}

	public function getSourcesWithNameLike($name, $limit = NULL, $offset = NULL)
	{
		$params = [];
		$route = $this->getRoute("sources");

		$params['query'] = [
			'name' => $name
		];

		static::decorateParams($params, $limit, $offset);

		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}

	public function findIdentifierByName($sourceName, $identifierName)
	{
		$source = $this->findSourceByName($sourceName);

		foreach($source->identifiers as $identifier)
		{
			if($identifier->name === $identifierName)
				return $identifier;
		}

		throw new RequestException("Source Identifier not found.");
	}

	
}