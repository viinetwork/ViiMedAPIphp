<?php namespace Viimed\PhpApi;

use RuntimeException;
use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Gateways\Gateway;
use Viimed\PhpApi\Gateways\SchemaGateway;

// Factory to bootstrap apis
class SchemaAPI {

	private function __construct(){}

	public static function connect()
	{
		$config = API::getConfig();

		// $manager = new GatewayManager;
		//
		// $manager->setGateway( new SchemaGateway( new Http($config['schemas'])) );
		//
		// return $manager;

		return new SchemaGateway( new Http($config['schemas']));
	}

}
