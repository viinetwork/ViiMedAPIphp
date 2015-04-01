<?php
namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\API;

// This test needs to have some known data on the viiidservice

class SourceGatewayTest extends \Codeception\TestCase\Test
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

		$count = $this->_gateway->getMetaArray()->total;

		$this->assertCount($count, $sources);
		$this->assertTrue( isset($sources[0]->identifiers) );

		return $sources;
	}

	public function testFindSourceByName()
	{
		$sources = $this->testGetAll();

		$source = $this->_gateway->findSourceByName($sources[0]->name);

		$this->assertEquals($sources[0]->description, $source->description);
	}

	public function testFindIdentifierByName()
	{
		$sources = $this->testGetAll();

		$identifier = $this->_gateway->findIdentifierByName($sources[0]->name, $sources[0]->identifiers[0]->name);

		$this->assertEquals($sources[0]->identifiers[0]->id, $identifier->id);
	}

	public function testFindExternalIDByValue()
	{
		$sources = $this->testGetAll();

		$source = $sources[0];
		$identifier = $sources[0]->identifiers[0];

		$externalIDs = $this->_gateway->getExternalIDs($source->id, $identifier->id);
		$value = $externalIDs[0]->value;

		$externalID = $this->_gateway->findExternalIDByValue($source->name, $identifier->name, $value);

		$this->assertEquals($value, $externalID->value);
	}

}