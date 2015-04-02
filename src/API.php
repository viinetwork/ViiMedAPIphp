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

	public static function connect($ViiPartnerID, $ViiPartnerSecret, $ViiClientID, $Identifier, $IdentifierID)
	{
		$manager = new GatewayManager;

		$config = static::getConfig();

		// Authservice
		$authserviceHttp = new Http(['base_url' => $config['base_urls']['authservice']]);
		$manager->setGateway(
			new AuthServiceGateway($authserviceHttp, new Signature)
		);
		$manager->authServices()->setCredentials($ViiPartnerID, $ViiPartnerSecret, $ViiClientID);

		// Create token
		$token = $manager->authServices()->generateToken($Identifier, $IdentifierID);

		// Create
		$httpConfig = [
			'base_url' => $config['base_urls']['globaluser'],
			'defaults' => [
				'query' => [
					'ViiPartnerID' => $ViiPartnerID,
					'ViiClientID' => $ViiClientID,
					'Identifier' => $Identifier,
					'IdentifierID' => $IdentifierID,
					'Token' => $token
				]
			]
		];

		// Globalusers, Patients, Emrs
		$manager->setGateway( new GlobalUserGateway( new Http($httpConfig)) )
				->setGateway( new PatientGateway( new Http($httpConfig)) )
				->setGateway( new EmrGateway( new Http($httpConfig)) )
				->setGateway( new SourceGateway( new Http($httpConfig)) );

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