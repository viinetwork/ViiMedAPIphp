<?php namespace Viimed\PhpApi\Interfaces;

interface GlobalUserInterface {
	public function findById($globaluser_id);
	public function getExternalIDs($globaluser_id);
	public function findExternalIDValue($globaluser_id, $source_name, $identifier_name = NULL);
}