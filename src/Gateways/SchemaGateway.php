<?php namespace Viimed\PhpApi\Gateways;

use StdClass, InvalidArgumentException;
use Viimed\PhpApi\Interfaces\SchemaInterface;
use Viimed\PhpApi\Exceptions\RequestException;

class SchemaGateway extends Gateway implements SchemaInterface {


	public function findRecordByUUID($uuid)
	{
		$route = $this->getRoute("records/$uuid");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}


	public function saveRecord($schemaAddress, StdClass $record)
	{
		$schemaAddress = ltrim($schemaAddress, '/');

		$route = $this->getRoute("records/$schemaAddress");

		$request = $this->http->createRequest("POST", $route, [
			'json' => (array) $record
		]);

		return $this->executeCall( $request )->data;
	}


	public function updateRecord(StdClass $record)
	{
		static::validateUUID($record);

		$uuid = $record->_uuid;

		$route = $this->getRoute("records/$uuid");

		$request = $this->http->createRequest("PUT", $route, [
			'json' => (array) $record
		]);

		return $this->executeCall( $request )->data;
	}


	public function deleteRecord(StdClass $record)
	{
		static::validateUUID($record);

		$uuid = $record->_uuid;

		$route = $this->getRoute("records/$uuid");

 	   $request = $this->http->createRequest("DELETE", $route, []);

 	   return $this->executeCall( $request )->data;
	}


	public function saveRecordMeta($uuid, StdClass $meta)
	{
		$route = $this->getRoute("records/$uuid/meta");

		$request = $this->http->createRequest("POST", $route, [
			'json' => (array) $meta
		]);

		return $this->executeCall( $request )->data;
	}
	

	public function searchRecordsBySchema($schemaAddress, StdClass $params)
	{
		$route = $this->getRoute("records/$schemaAddress/search");

		$request = $this->http->createRequest("GET", $route, [
			'query' => json_encode($params),
		]);

		return $this->executeCall( $request )->data;
	}


	private static function validateUUID(StdClass $record)
	{
		if( ! property_exists($record, '_uuid'))
		{
			throw new InvalidArgumentException("Schema record must have a '_uuid' property for update.");
		}
	}

}
