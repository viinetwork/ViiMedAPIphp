<?php namespace Viimed\PhpApi\Gateways;

use DateTime;
use Viimed\PhpApi\Interfaces\PatientInterface;
use Viimed\PhpApi\Exceptions\RequestException;
use Viimed\PhpApi\Models\Patient;

class PatientGateway extends Gateway implements PatientInterface {

	const DOB_FORMAT = 'Y-m-d';

	public function findById($globaluser_id)
	{
		return $this->findPatientByGlobalUserID($globaluser_id);
	}

	public function getAll($limit = NULL, $offset = NULL)
	{
		$params = [];
		$route = $this->getRoute("patients");

		if( ! is_null($limit) || ! is_null($offset))
		{
			$query = [];
			if( ! is_null($limit)) $query['limit'] = $limit;
			if( ! is_null($offset)) $query['offset'] = $offset;
			$params['query'] = $query;	
		}
		
		$request = $this->http->createRequest("GET", $route, $params);

		return $this->executeCall( $request )->data;
	}

	public function findPatientByGlobalUserID($globaluser_id)
	{
		$route = $this->getRoute("patients/$globaluser_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function getPatientsLike(Patient $patient, $limit = NULL, $offset = NULL)
	{
		extract((array) $patient);

		return $this->searchForPatientsWhere($dob, $lname, $ssn, $gender, $limit, $offset);
	}

	public function save(Patient $patient)
	{
		 // update vs save if id is set
		if(isset($patient->globaluser_id))
		{
			return $this->updatePatient($patient);
		}

		$route = $this->getRoute("patients");

		$request = $this->http->createRequest("POST", $route, [
			'body' => (array) $patient
		]);

		return $this->executeCall( $request )->data;
	}

	protected function updatePatient(Patient $patient)
	{
		$route = $this->getRoute("patients/{$patient->globaluser_id}");

		$params = (array) $patient;
		$params['_method'] = 'PUT';

		$request = $this->http->createRequest("POST", $route, [
			'body' => $params
		]);

		return $this->executeCall( $request )->data;
	}

	public function delete(Patient $patient)
	{
		$route = $this->getRoute("patients/{$patient->globaluser_id}");

		$request = $this->http->createRequest("DELETE", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function searchForPatientsWhere(DateTime $dob = NULL, $lname = NULL, $ssn = NULL, $gender = NULL, $limit = NULL, $offset = NULL)
	{
		$dob = is_null($dob) ? $dob : $dob->format(static::DOB_FORMAT);

		$query = array_filter(compact('dob', 'lname', 'ssn', 'gender', 'limit', 'offset'), function($q){
			return ! is_null($q);
		});

		$route = $this->getRoute("patients");

		$request = $this->http->createRequest("GET", $route, [
			'query' => $query
		]);

		return $this->executeCall( $request )->data;
	}

	public function findPatientWhere(DateTime $dob, $lname, $ssn, $gender)
	{
		$patient = $this->searchForPatientsWhere($dob, $lname, $ssn, $gender);

		if( count($patient) !== 1)
			throw new RequestException("Patient could not be found.");

		return current($patient);
	}
}