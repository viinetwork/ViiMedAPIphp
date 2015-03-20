<?php namespace Viimed\PhpApi\Interfaces;

use Viimed\PhpApi\Models\ExternalID;

interface GlobalUserInterface {
	public function findById($globaluser_id);
	public function getAll($limit = NULL, $offset = NULL);
	public function getExternalIDs($globaluser_id);
	public function findExternalIDValue($globaluser_id, $source_name, $identifier_name = NULL);
	public function addExternalID($globaluser_id, ExternalID $externalID);
	public function removeExternalID($globaluser_id, $externalID_id);
}