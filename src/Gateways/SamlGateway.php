<?php namespace Viimed\PhpApi\Gateways;

use GuzzleHttp\Client as Http;
use Laravel\Input;
use Laravel\Request;
use Laravel\Response;
use Viimed\PhpApi\Interfaces\SamlInterface;
use ViiSetting;

class SamlGateway extends Gateway implements SamlInterface
{
  public function __construct(Http $http)
  {
    $http->setDefaultOption('allow_redirects', false);

    $this->settings = ViiSetting::load_setting('sso');
    $this->http = $http;
  }

  public function metadata()
  {
    $route = $this->getRoute('/metadata');

    $request = $this->http->createRequest('GET', $route, []);

    return $this->executeCall($request, $expectJson = false);
  }

  public function login()
  {
    $route = $this->getRoute('/login');

    $request = $this->http->createRequest('GET', $route, []);

    return $this->executeCall($request, $expectJson = false, $expectRedirect = true);
  }

  public function logout()
  {
    $route = $this->getRoute('/logout');

    $request = $this->http->createRequest('GET', $route, []);

    return $this->executeCall($request, $expectJson = false, $expectRedirect = true);
  }

  public function acs()
  {
    $route = $this->getRoute('/acs');

    $request = $this->http->createRequest('POST', $route, [
        'body' => [Input::all()]
    ]);

    return $this->executeCall($request, $expectJson = false);
  }

  public function sls()
  {
    $route = $this->getRoute('/sls');

    $request = $this->http->createRequest('GET', $route, []);

    return $this->executeCall($request, $expectJson = false, $expectRedirect = true);
  }
}
