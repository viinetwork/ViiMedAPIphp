<?php namespace Viimed\PhpApi;

use GuzzleHttp\Client as Http;
use Viimed\PhpApi\Gateways\SamlGateway;

// Factory to bootstrap apis
class SamlAPI
{
  private function __construct() {}

  public static function connect()
  {
    $config = API::getConfig();

    return new SamlGateway(new Http($config['saml']));
  }

}
