<?php namespace Viimed\ViiGlobalID\Interfaces;

use DateTime;
use Viimed\ViiGlobalID\Models\Patient;

interface PatientInterface {
	public function findPatientByGlobalUserId($globaluser_id);
	public function findEmrById($emr_id);
	public function searchForPatientsWhere(DateTime $dob = NULL, $lname = NULL, $ssn = NULL, $gender = NULL, $limit = NULL, $offset = NULL);
	public function findPatientWhere(DateTime $dob, $lname, $ssn, $gender);
	public function savePatient(Patient $patient);
	public function deletePatient(Patient $patient);
}