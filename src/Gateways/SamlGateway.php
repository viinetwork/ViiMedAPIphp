<?php namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\Interfaces\SamlInterface;

class SamlGateway extends Gateway implements SamlInterface
{
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

    return $this->executeCall($request, $expectJson = false);
  }

  public function logout()
  {
    $route = $this->getRoute('/logout');

    $request = $this->http->createRequest('GET', $route, []);

    return $this->executeCall($request, $expectJson = false);
  }

  public function acs()
  {
    $route = $this->getRoute('/acs');

    $request = $this->http->createRequest('POST', $route, [
        'form_params' => [Input::all()]
    ]);

    return $this->executeCall($request, $expectJson = false);
  }

  public function sls()
  {
    $route = $this->getRoute('/sls');

    $request = $this->http->createRequest('GET', $route, []);

    return $this->executeCall($request, $expectJson = false);
  }
}
