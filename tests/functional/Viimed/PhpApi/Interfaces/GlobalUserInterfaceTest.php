<?php namespace Viimed\PhpApi\Interfaces;


class GlobalUserInterfaceTest extends \FunctionalTest
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

		$meta = $this->repo->getMetaArray();

		$count = min($meta->limit, $meta->total);

		$this->assertEquals($count, count($globalUsers));

		foreach($globalUsers as $guser)
		{
			$this->assertFieldsExistOnObject($guser, ['id', 'externalIDs']);
		}

		return $globalUsers;
	}

	public function testFindById()
	{
		$globalUsers = $this->testGetAll();

		$guser = $globalUsers[0];

		$globaluser = $this->repo->findById($guser->id);

		$this->assertEquals($guser->id, $globaluser->id);
	}

}