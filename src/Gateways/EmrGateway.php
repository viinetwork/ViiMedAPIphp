<?php namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Interfaces\EmrInterface;

class EmrGateway extends Gateway implements EmrInterface {

	public function findById($emr_id)
	{
		$route = $this->getRoute("emrs/$emr_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}
}