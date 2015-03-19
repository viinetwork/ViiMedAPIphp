<?php namespace Viimed\ViiGlobalID;

use DateTime;
use InvalidArgumentException;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\RequestException;
use Aaronbullard\Exceptions\NotFoundException;
use Viimed\ViimedAPI\Exceptions\ViimedAPIException;
use Viimed\ViiGlobalID\Interfaces\PassportInterface;
use Viimed\ViiGlobalID\Interfaces\PatientInterface;
use Viimed\ViiGlobalID\Models\Patient;

class PatientGateway extends Gateway implements PatientInterface {

	public function findPatientByGlobalUserID($globaluser_id)
	{
		$route = $this->getRoute("patients/$globaluser_id");

		$request = $this->http->createRequest("GET", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function savePatient(Patient $patient)
	{
		 // update vs save if id is set
		if(isset($patient->globaluser_id))
		{
			return $this->updatePatient($patient);
		}

		$route = $this->getRoute("globalusers");

		$request = $this->http->createRequest("POST", $route, [
			'body' => (array) $patient
		]);

		return $this->executeCall( $request )->data;
	}

	protected function updatePatient(Patient $patient)
	{
		$route = $this->getRoute("globalusers");

		$params = (array) $patient;
		$params['_method'] = 'PUT';

		$request = $this->http->createRequest("PUT", $route, [
			'body' => $params
		]);

		return $this->executeCall( $request )->data;
	}

	public function deletePatient(Patient $patient)
	{
		$route = $this->getRout("globalusers/{$patient->globaluser_id}");

		$request = $this->http->createRequest("DELETE", $route, []);

		return $this->executeCall( $request )->data;
	}

	public function searchForPatientsWhere(DateTime $dob = NULL, $lname = NULL, $ssn = NULL, $gender = NULL, $limit = NULL, $offset = NULL)
	{
		$dob = $dob->format('Y-m-d');

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
			throw new NotFoundException("Patient could not be found.");

		return $patient[0];
	}
}