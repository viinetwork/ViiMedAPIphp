<?php namespace Viimed\PhpApi\Gateways;


class GatewayTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before()
	{
	}

	protected function _after()
	{
	}

	// tests
	public function testLimitAndOffsetDecorator()
	{
		$params = [];
		Gateway::decorateParams($params, 10, 10);
		$this->assertEquals(10, $params['query']['limit']);
		$this->assertEquals(10, $params['query']['offset']);

		$params = [];
		Gateway::decorateParams($params, NULL, NULL);
		$this->assertFalse( isset($params['query']));
	}

}