<?php
namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\API;

// This test needs to have some known data on the viiidservice

abstract class SourceGatewayTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \FunctionalTester
	 */
	protected $tester;

	protected $_gateway;

	protected function _before()
	{
		$this->_gateway = API::connect()->sources();
	}


	// tests
	public function testGetAll()
	{
		$sources = $this->_gateway->getAll();

		$this->assertCount(20, $sources);
		$this->assertTrue( isset($sources[0]->identifiers) );
	}

	public function testFindSourceByName()
	{
		$source = $this->_gateway->findSourceByName('ViimedSiteFAKE');

		$this->assertEquals("Fake Viimed Site.", $source->description);
	}

	public function testFindIdentifierByName()
	{
		$identifier = $this->_gateway->findIdentifierByName('Goodwin Ltd', 'aut');

		$this->assertEquals(2, $identifier->id);
	}

}