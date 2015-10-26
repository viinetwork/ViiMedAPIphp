<?php namespace Viimed\PhpApi\Gateways;

use StdClass, InvalidArgumentException;
use Viimed\PhpApi\Interfaces\IngestionInterface;
use Viimed\PhpApi\Exceptions\RequestException;

class IngestionGateway extends Gateway implements IngestionInterface
{
    public function post()
    {
        $route = $this->getRoute("messages/post");

        $request = $this->http->createRequest("POST", $route, [
            'body' => [Input::all()]
        ]);

        return json_decode($this->executeCall($request, $expectJson = false));
    }
}
