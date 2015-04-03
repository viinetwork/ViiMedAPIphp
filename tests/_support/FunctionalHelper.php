<?php namespace Codeception\Module;

use Viimed\PhpApi\API;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

	public function getAPI($Identifier = 'GetWellUser', $IdentifierID = 42)
	{
		return API::connect('VIIMED_1', '39dc4799819eb3632e3e20d72955d14f', 'DEVELOPR', $Identifier, $IdentifierID);
	}

	public function getGlobalUserInterface()
	{
		return $this->getAPI()->globalUsers();
	}

}
