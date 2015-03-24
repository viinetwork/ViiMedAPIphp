<?php namespace Viimed\PhpApi;

use RuntimeException;
use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Services\Signature;
use Viimed\PhpApi\Gateways\Gateway;
use Viimed\PhpApi\Gateways\AuthServiceGateway;
use Viimed\PhpApi\Gateways\GlobalUserGateway;
use Viimed\PhpApi\Gateways\PatientGateway;
use Viimed\PhpApi\Gateways\EmrGateway;

// Factory to bootstrap apis
class API {

	private function __construct(){}

	public static function connect($ViiPartnerID, $ViiPartnerSecret, $ViiClientID, $Identifier = 'API', $IdentifierID = '1')
	{
		$manager = new GatewayManager;

		$config = static::getConfig();

		// Authservice
		$authserviceHttp = new Http(['base_url' => $config['base_urls']['authservice']]);
		$manager->setGateway(
			new AuthServiceGateway($authserviceHttp, new Signature, $ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
		);

		// static::hydrateWithCredentials($manager, compact('ViiPartnerID', 'ViiClientID', 'Identifier', 'IdentifierID'));

		// Globalusers, Patients, Emrs
		$globaluserHttp = new Http(['base_url' => $config['base_urls']['globaluser']]);
		$manager->setGateway( new GlobalUserGateway($globaluserHttp) )
				->setGateway( new PatientGateway($globaluserHttp) )
				->setGateway( new EmrGateway($globaluserHttp) );

		return $manager;
	}

	protected static function hydrateWithCredentials(GatewayManager $manager, array $credentials)
	{
		$Token = $manager->authServices()->generateToken($credentials['Identifier'], $credentials['IdentifierID']);

		$credentials['Token'] = $Token;

		Gateway::setCredentials($credentials);
	}

	public static function getConfig()
	{
		$config = require __DIR__ . '/config.php';

		if( ! is_array($config))
			throw new RuntimeException("Error retrieving configuration.");

		return $config;
	}

}