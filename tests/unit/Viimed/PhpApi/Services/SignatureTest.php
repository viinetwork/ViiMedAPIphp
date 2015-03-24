<?php namespace Viimed\PhpApi\Services;


class SignatureTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	// tests
	public function testMakingAHash()
	{
		$secret = 'mySecret';
		$url = 'https://localhost.com';
		$query = [
			'one' => 1,
			'two' => 2
		];
		$hash = (new Signature())->makeHash($secret, $url, $query);

		$this->assertEquals('2623f476b466a1c8d08871cb1f878d11826c07b8', $hash);
	}

	public function testItStripsEndingSlashes()
	{
		$secret = 'mySecret';
		$url = 'https://localhost.com/';
		$query = [
			'one' => 1,
			'two' => 2
		];
		$hash = (new Signature())->makeHash($secret, $url, $query);

		$this->assertEquals('2623f476b466a1c8d08871cb1f878d11826c07b8', $hash);
	}

}