<?php namespace Viimed\PhpApi;

use RuntimeException;
use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Services\Signature;
use Viimed\PhpApi\Gateways\Gateway;
use Viimed\PhpApi\Gateways\AuthServiceGateway;
use Viimed\PhpApi\Gateways\GlobalUserGateway;
use Viimed\PhpApi\Gateways\PatientGateway;
use Viimed\PhpApi\Gateways\EmrGateway;
use Viimed\PhpApi\Gateways\SourceGateway;

// Factory to bootstrap apis
class API {

	private function __construct(){}

	public static function connect()
	{
		$manager = new GatewayManager;

		$config = static::getConfig();

		// Authservice
		$authserviceHttp = new Http(['base_url' => $config['base_urls']['authservice']]);
		$manager->setGateway(
			new AuthServiceGateway($authserviceHttp, new Signature)
		);

		// Globalusers, Patients, Emrs
		$globaluserHttp = new Http(['base_url' => $config['base_urls']['globaluser']]);
		$manager->setGateway( new GlobalUserGateway($globaluserHttp) )
				->setGateway( new PatientGateway($globaluserHttp) )
				->setGateway( new EmrGateway($globaluserHttp) )
				->setGateway( new SourceGateway($globaluserHttp) );

		return $manager;
	}

	public static function getConfig()
	{
		$config = require __DIR__ . '/config.php';

		if( ! is_array($config))
			throw new RuntimeException("Error retrieving configuration.");

		return $config;
	}

}