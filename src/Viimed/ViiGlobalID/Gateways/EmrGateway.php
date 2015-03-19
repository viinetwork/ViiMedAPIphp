<?php namespace Viimed\ViiGlobalID\Gateways;

use Viimed\ViiGlobalID\Interfaces\EmrInterface;

class EmrGateway implements EmrInterface {

	public function findEmrById($emr_id)
	{
		$route = $this->getRoute("emrs/$emr_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}
}