<?php namespace Viimed\PhpApi;

use RuntimeException;
use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Gateways\Gateway;
use Viimed\PhpApi\Gateways\HcpcsGateway;

// Factory to bootstrap apis
class HcpcsAPI {

	private function __construct(){}

	public static function connect()
	{
		$config = API::getConfig();

		return new HcpcsGateway( new Http($config['hcpcs']));
	}

}
