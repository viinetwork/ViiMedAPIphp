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
		$manager = static::constructGatewayManagerWithAuthService($ViiPartnerID, $ViiPartnerSecret, $ViiClientID);

		// Create token
		$Token = $manager->authServices()->generateToken($Identifier, $IdentifierID);

		// Create
		$credentials = compact('ViiPartnerID', 'ViiClientID', 'Identifier', 'IdentifierID', 'Token');

		$manager = static::setGateways($manager, $credentials);

		return $manager;
	}

	public static function connectWithToken($ViiPartnerID, $ViiClientID, $Identifier, $IdentifierID, $Token)
	{
		$manager = static::constructGatewayManagerWithAuthService($ViiPartnerID, $ViiPartnerSecret, $ViiClientID);

		// Create
		$credentials = compact('ViiPartnerID', 'ViiClientID', 'Identifier', 'IdentifierID', 'Token');

		$manager = static::setGateways($manager, $credentials);

		return $manager;
	}

	private static function constructGatewayManagerWithAuthService($ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
	{
		$manager = new GatewayManager;

		$config = static::getConfig();

		// Authservice
		$manager->setGateway(
			new AuthServiceGateway(new Http($config['authtokens']), new Signature)
		);
		$manager->authServices()->setCredentials($ViiPartnerID, $ViiPartnerSecret, $ViiClientID);

		return $manager;
	}

	private static function setGateways(GatewayManager $manager, array $credentials = [])
	{
		$config = static::getConfig();

		// Create
		$config['viiid']['defaults'] = [
			'query' => $credentials
		];

		// Globalusers, Patients, Emrs
		$manager->setGateway( new GlobalUserGateway( new Http($config['viiid'])) )
				->setGateway( new PatientGateway( new Http($config['viiid'])) )
				->setGateway( new EmrGateway( new Http($config['viiid'])) )
				->setGateway( new SourceGateway( new Http($config['viiid'])) );

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