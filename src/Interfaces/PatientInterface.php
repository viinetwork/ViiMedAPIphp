<?php namespace Viimed\PhpApi\Interfaces;

use DateTime;
use Viimed\PhpApi\Models\Patient;

interface PatientInterface {
	public function findPatientByGlobalUserId($globaluser_id);
	public function searchForPatientsWhere(DateTime $dob = NULL, $lname = NULL, $ssn = NULL, $gender = NULL, $limit = NULL, $offset = NULL);
	public function findPatientWhere(DateTime $dob, $lname, $ssn, $gender);
	public function save(Patient $patient);
	public function delete(Patient $patient);
}