<?php namespace Viimed\PhpApi\Gateways;

use StdClass, InvalidArgumentException;
use Laravel\Input;
use Laravel\Request;
use Viimed\PhpApi\Interfaces\IngestionInterface;
use Viimed\PhpApi\Exceptions\RequestException;

class IngestionGateway extends Gateway implements IngestionInterface
{
    public function post()
    {
        $route = $this->getRoute("/post");

        $request = $this->http->createRequest("POST", $route, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => Request::getContent()
        ]);

        return $this->executeCall($request);
    }
}
