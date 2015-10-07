<?php namespace Viimed\PhpApi;

use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Gateways\IdentityGateway;

// Factory to bootstrap apis
class IdentityAPI {

	private function __construct(){}

	public static function connect()
	{
		$config = API::getConfig();
		
		return new IdentityGateway( new Http($config['identity']));
	}

}
