<?php namespace Viimed\PhpApi\Gateways;

use Viimed\PhpApi\API;

// This test needs to have some known data on the viiidservice

class SourceGatewayTest extends \FunctionalTest
{
	/**
	 * @var \FunctionalTester
	 */
	protected $tester;

	protected $_gateway;

	protected function _before()
	{
		$this->_gateway = $this->tester->getAPI()->sources();
	}


	// tests
	public function testGetAll()
	{
		$sources = $this->_gateway->getAll();

		$meta = $this->_gateway->getMetaArray();
		$count = min($meta->limit, $meta->total);

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