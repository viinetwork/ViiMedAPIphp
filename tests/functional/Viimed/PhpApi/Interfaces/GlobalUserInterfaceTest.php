<?php namespace Viimed\PhpApi\Interfaces;


class GlobalUserInterfaceTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \FunctionalTester
	 */
	protected $tester;

	protected $repo;

	protected function _before()
	{
		$this->repo = $this->tester->getGlobalUserInterface();
	}

	public function testGetAll()
	{
		$globalUsers = $this->repo->getAll();
	}

}