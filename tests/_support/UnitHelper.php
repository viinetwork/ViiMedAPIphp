<?php namespace Codeception\Module;

use Mockery;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class UnitHelper extends \Codeception\Module
{

	public function mockHttpWithRequest($verb, $route, array $params, $returnData, $status = 'success')
	{
		$request = $this->makeRequestInterface();

		$http = $this->makeHttp();
	
		$http->shouldReceive('createRequest')->with($verb, $route, $params)->once()->andReturn( $request );
		$http->shouldReceive('send')->with( $request )->once()->andReturn($http)
			->shouldReceive('getBody')->once()->andReturn( $http )
			->shouldReceive('getContents')->once()->andReturn( $this->makeResponseJsonString('success', $returnData) );

		return $http;
	}

	public function makeHttp()
	{
		$http = Mockery::mock('GuzzleHttp\\Client');

		return $http;
	}

	public function makeRequestInterface()
	{
		return Mockery::mock('GuzzleHttp\\Message\\RequestInterface');
	}

	public function makeResponseJsonString($status, $data)
	{
		$obj = [
			'status' => $status,
			'data' => $data
		];

		return json_encode( $obj );
	}
}
