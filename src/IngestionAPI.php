<?php namespace Viimed\PhpApi;

use RuntimeException;
use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Gateways\Gateway;
use Viimed\PhpApi\Gateways\IngestionGateway;

// Factory to bootstrap apis
class IngestionAPI {

  private function __construct(){}

  public static function connect()
  {
    $config = API::getConfig();

    // $manager = new GatewayManager;
    //
    // $manager->setGateway( new SchemaGateway( new Http($config['schemas'])) );
    //
    // return $manager;

    return new IngestionGateway( new Http($config['ingestion']));
  }

}
