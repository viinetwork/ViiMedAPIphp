<?php namespace Viimed\PhpApi\Gateways;

use Viimed\Contracts\Repositories\EmrsRepository;

class EmrGateway extends Gateway implements EmrsRepository {

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

		static::decorateParams($params, $limit, $offset);

		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}
}