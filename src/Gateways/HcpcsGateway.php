<?php
namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Interfaces\HcpcsInterface;

class HcpcsGateway extends Gateway implements HcpcsInterface 
{
	public function findCodeCurrentVersion($code)
	{
		$route = $this->getRoute($code);

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}
    
    public function findCodeVersion($code, $version)
    {
		$route = $this->getRoute($code."/versions/".$version);

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
    }

    public function getAllCodeVersions($code)
    {
    	$route = $this->getRoute($code."/versions");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
    }

    public function searchCurrentVersion(Array $queryParams)
    {
    	$route = $this->getRoute("search");

		$request = $this->http->createRequest("GET", $route, [
			'query' => $queryParams,
		]);

		return $this->executeCall( $request )->data;
    }

    public function searchVersion($version, Array $queryParams)
    {
    	$route = $this->getRoute("search/versions/".$version);

		$request = $this->http->createRequest("GET", $route, [
			'query' => $queryParams,
		]);

		return $this->executeCall( $request )->data;
    }

    public function searchAllVersions(Array $queryParams)
    {
    	$route = $this->getRoute("search/versions");

		$request = $this->http->createRequest("GET", $route, [
			'query' => $queryParams,
		]);

		return $this->executeCall( $request )->data;
    }
}