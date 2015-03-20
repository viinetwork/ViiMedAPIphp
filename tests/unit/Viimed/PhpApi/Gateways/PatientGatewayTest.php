<?php namespace Viimed\PhpApi\Gateways;

use Mockery;
use Viimed\PhpApi\Models\Patient;

class PatientGatewayTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _after()
	{
		Mockery::close();
	}

	// tests
	public function testItImplementsPatientInterface()
	{
		$http = $this->tester->makeHttp();
		$gateway = new PatientGateway($http);
		$this->assertInstanceOf('Viimed\\PhpApi\\Interfaces\\PatientInterface', $gateway);
	}

	// tests
	public function testFindById()
	{
		$http = $this->tester->mockHttpWithRequest('GET', 'api/v2/patients/1', [], TRUE);
		$gateway = new PatientGateway($http);

		$this->assertTrue( $gateway->findById(1) );
	}

	public function testFindPatientByGlobalUserID()
	{
		$http = $this->tester->mockHttpWithRequest('GET', 'api/v2/patients/123', [], TRUE);
		$gateway = new PatientGateway($http);

		$this->assertTrue( $gateway->findPatientByGlobalUserID(123) );
	}

	public function testSaveNewPatient()
	{
		$patient = Mockery::mock('Viimed\\PhpApi\\Models\\Patient');
		$patient->globaluser_id = NULL;

		$params = [
			'body' => (array) $patient
		];

		$http = $this->tester->mockHttpWithRequest('POST', 'api/v2/patients', $params, TRUE);

		$gateway = new PatientGateway($http);

		$this->assertTrue( $gateway->save($patient) );
	}

	public function testUpdateOfPatient()
	{
		$patient = Mockery::mock('Viimed\\PhpApi\\Models\\Patient');
		$patient->globaluser_id = 123;

		$params = [
			'body' => (array) $patient
		];
		$params['body']['_method'] = 'PUT';

		$http = $this->tester->mockHttpWithRequest('POST', 'api/v2/patients/123', $params, TRUE);

		$gateway = new PatientGateway($http);

		$this->assertTrue( $gateway->save($patient) );
	}

	public function testDeletePatient()
	{
		$patient = Mockery::mock('Viimed\\PhpApi\\Models\\Patient');
		$patient->globaluser_id = 123;

		$http = $this->tester->mockHttpWithRequest('DELETE', 'api/v2/patients/123', [], TRUE);

		$gateway = new PatientGateway($http);

		$this->assertTrue( $gateway->delete($patient) );
	}

	public function testSearchForPatientsWhere()
	{
		$dob = new \DateTime('2000-01-15');

		$params = [
			'query' => [
				'dob' => '2000-01-15',
				'lname' => 'LastName'
			]
		];

		$http = $this->tester->mockHttpWithRequest('GET', 'api/v2/patients', $params, TRUE);

		$gateway = new PatientGateway($http);

		$this->assertTrue( $gateway->searchForPatientsWhere($dob, 'LastName') );
	}

	public function testGetPatientsLike()
	{
		$dob = new \DateTime('2000-01-15');

		$params = [
			'query' => [
				'dob' => '2000-01-15',
				'lname' => 'LastName'
			]
		];

		$http = $this->tester->mockHttpWithRequest('GET', 'api/v2/patients', $params, TRUE);

		$gateway = new PatientGateway($http);
		$patient = new Patient(NULL, 'LastName', $dob, NULL);
		$this->assertTrue( $gateway->getPatientsLike($patient) );
	}

}