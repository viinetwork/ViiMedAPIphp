<?php
namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Interfaces\IdentityInterface;

class IdentityGateway extends Gateway implements IdentityInterface 
{
	public function registerIdentity($system_name, $system_id, Array $traits)
	{
		$route = $this->getRoute("register");

		$payload = [
			'system' => [
				'name' => $system_name,
				'identifier' => $system_id,
			],
			'traits' => $traits,
		];

		$request = $this->http->createRequest("POST", $route, ['json' => $payload]);

		return $this->executeCall( $request );
	}
    
    public function findIdentity($system_name, $system_id)
    {
		$route = $this->getRoute("find/$system_name/$system_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request );
    }
}