<?php namespace Viimed\PhpApi\Interfaces;

interface EmrInterface {
	public function findById($emr_id);
	public function getAll($limit = NULL, $offset = NULL);
}