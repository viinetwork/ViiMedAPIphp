<?php namespace Viimed\PhpApi\Gateways;

use Viimed\Contracts\Repositories\SourcesRepository;
use Viimed\PhpApi\Exceptions\RequestException;

class SourceGateway extends Gateway implements SourcesRepository  {

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

	public function saveSource($name, $description = NULL)
	{
		$params = [];
		$params['body'] = [
			'Name' => $name,
			'Description' => $description
		];

		$route = $this->getRoute("sources/{$sourceId}");

		$request = $this->http->createRequest("POST", $route, $params);

		return $this->executeCall( $request )->data;
	}


	#################
	# Identifiers
	#################

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

	public function saveIdentifier($sourceId, $name, $description)
	{
		$params = [];
		$params['body'] = [
			'Name' => $name,
			'Description' => $description
		];

		$route = $this->getRoute("sources/{$sourceId}/identifiers");

		$request = $this->http->createRequest("POST", $route, $params);

		return $this->executeCall( $request )->data;
	}

	#################
	# ExternalIDs
	#################

	public function getExternalIDs($sourceId, $identifierId, $limit = NULL, $offset = NULL)
	{
		$params = [];

		static::decorateParams($params, $limit, $offset);

		$route = $this->getRoute("sources/{$sourceId}/identifiers/{$identifierId}/externalids");

		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}

	public function findExternalIDByValue($sourceName, $identifierName, $value)
	{
		$params = [];
		$params['query'] = [
			'value' => $value
		];

		$identifier = $this->findIdentifierByName($sourceName, $identifierName);

		$route = $this->getRoute("sources/{$identifier->source_id}/identifiers/{$identifier->id}/externalids");

		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}
	
}