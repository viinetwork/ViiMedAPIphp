<?php namespace Viimed\ViiGlobalID\Interfaces;

interface PassportInterface {
	public function findGlobalUserById($globaluser_id);
	public function getExternalIDs($globaluser_id);
	public function findExternalIDValue($globaluser_id, $source_name, $identifier_name = NULL);
}