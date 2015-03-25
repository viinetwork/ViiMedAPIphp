<?php namespace Viimed\PhpApi\Gateways;

use Viimed\Contracts\Repositories\Repository;
use Viimed\PhpApi\Interfaces\GlobalUserInterface;
use Viimed\Contracts\Repositories\GlobalUsersRepository;
use Viimed\PhpApi\Models\ExternalID;
use Viimed\PhpApi\Exceptions\RequestException;

class GlobalUserGateway extends Gateway implements GlobalUserInterface, GlobalUsersRepository, Repository {

	public function findById($globaluser_id)
	{
		$route = $this->getRoute("globalusers/$globaluser_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function getAll($limit = NULL, $offset = NULL)
	{
		$params = [];
		$route = $this->getRoute("globalusers");

		if( ! is_null($limit) || ! is_null($offset))
		{
			$query = [];
			if( ! is_null($limit)) $query['limit'] = $limit;
			if( ! is_null($offset)) $query['offset'] = $offset;
			$params['query'] = $query;	
		}
		
		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}

	public function getExternalIDs($globaluser_id)
	{
		$globaluser = $this->findById($globaluser_id);

		return $globaluser->externalIDs;
	}

	public function findExternalIDValue($globaluser_id, $source_name, $identifier_name = NULL)
	{
		$externalIDs = $this->getExternalIDs($globaluser_id);

		$filtered = array_filter($externalIDs, function($extID) use ($source_name, $identifier_name){
			if( is_null($identifier_name))
				return $extID->source_name == $source_name;

			return ($extID->source_name == $source_name) && ($extID->$identifier_name == $identifier_name);
		});

		if( count($filtered) !== 1)
			throw new RequestException("ExternalID not found.");

		return current($filtered)->value;
	}

	public function addExternalID($globaluser_id, ExternalID $externalID)
	{
		$route = $this->getRoute("globalusers/$globaluser_id");

		$request = $this->http->createRequest("POST", $route, [
			'body' => [
				'SourceIdentifierID' => $externalID->SourceIdentifierID,
				'Value' => $externalID->Value
			]
		]);

		return $this->executeCall( $request )->data;
	}

	public function removeExternalID($globaluser_id, $externalID_id)
	{
		$route = $this->getRoute("globalusers/$globaluser_id/externalids/$externalID_id");

		$request = $this->http->createRequest("DELETE", $route, []);

		return $this->executeCall( $request )->data;
	}

}