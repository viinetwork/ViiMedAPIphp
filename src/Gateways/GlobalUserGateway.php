<?php namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Interfaces\GlobalUserInterface;
use Viimed\PhpApi\Exceptions\RequestException;

class GlobalUserGateway extends Gateway implements GlobalUserInterface {

	public function findById($globaluser_id)
	{
		$route = $this->getRoute("globalusers/$globaluser_id");

		$request = $this->http->createRequest("GET", $route, []);

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

}