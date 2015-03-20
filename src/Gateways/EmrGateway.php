<?php namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Interfaces\EmrInterface;

class EmrGateway extends Gateway implements EmrInterface {

	public function findById($emr_id)
	{
		$route = $this->getRoute("emrs/$emr_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function getAll($limit = NULL, $offset = NULL)
	{
		$params = [];
		$route = $this->getRoute("emrs");

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
}