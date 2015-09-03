<?php namespace Viimed\PhpApi\Interfaces;

use StdClass;

interface SchemaInterface {
    public function findRecordByUuid($uuid);
    public function saveRecord($schemaAddress, StdClass $record);
	public function updateRecord(StdClass $record);
	public function deleteRecord(StdClass $record);
    public function saveRecordMeta($uuid, StdClass $meta);
    public function getRecordsBySchema($schemaAddress, Array $params = []);
}
