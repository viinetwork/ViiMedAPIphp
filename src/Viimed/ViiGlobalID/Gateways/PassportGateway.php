<?php namespace Viimed\ViiGlobalID\Gateways;

use InvalidArgumentException;
use Viimed\ViiGlobalID\Interfaces\PassportInterface;

class PassportGateway implements PassportInterface {

	public function findGlobalUserById($globaluser_id)
	{
		$route = $this->getRoute("globalusers/$globaluser_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function getExternalIDs($globaluser_id)
	{
		$globaluser = $this->findGlobalUserById($globaluser_id);

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

		if( count($filtered) > 1)
			throw new InvalidArgumentException("There is more than one External ID for this source. Please provide an Identifier Name.");

		return $filtered[0]->value;
	}

}