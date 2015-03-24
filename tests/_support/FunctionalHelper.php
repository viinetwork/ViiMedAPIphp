<?php namespace Codeception\Module;

use Viimed\PhpApi\API;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

	public function getAPI()
	{
		return API::connect();
	}

	public function getGlobalUserInterface()
	{
		return $this->getAPI()->globalUsers();
	}

}
