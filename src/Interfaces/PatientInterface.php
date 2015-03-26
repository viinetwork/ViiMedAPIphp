<?php namespace Viimed\PhpApi\Interfaces;

use Viimed\PhpApi\Models\Patient;

interface PatientInterface {
	public function getPatientsLike(Patient $patient, $limit = NULL, $offset = NULL);
	public function save(Patient $patient);
	public function delete(Patient $patient);
}