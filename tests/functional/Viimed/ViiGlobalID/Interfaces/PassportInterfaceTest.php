<?php namespace Viimed\ViiGlobalID\Interfaces;

use DateTime;
use Viimed\ViiGlobalID\Passport;
use Viimed\ViiGlobalID\Models\Patient;

class PassportInterfaceTest extends \Codeception\TestCase\Test
{
	/**
	 * @var \FunctionalTester
	 */
	protected $tester;
	
	protected $interface;

	protected function _before()
	{
		$this->interface = Passport::connect('http://viiidservice.app:80/');
	}

	// tests
	public function testItImplementsInterface()
	{
		$this->assertInstanceOf('Viimed\\ViiGlobalID\\Interfaces\\PassportInterface', $this->interface, 'Class does not implement PassportInterface');
		$this->assertInstanceOf('Viimed\\ViiGlobalID\\Interfaces\\PatientInterface', $this->interface, 'Class does not implement PatientInterface');
	}

	public function testSavingAPatient()
	{
		$this->interface->savePatient($patient);
	}

/*
	public function testItGetsGlobalUserById()
	{
		$globaluser = $this->interface->findGlobalUserById("c9508493bc9e012d1837114659e5dac5");

		$this->assertEquals("ViimedSite_1", $globaluser->externalIDs[0]->source_name);
	}

	public function testItGetsExternalIDs()
	{
		$externalIDs = $this->interface->getExternalIDs("c9508493bc9e012d1837114659e5dac5");

		$this->assertEquals("ViimedSite_1", $externalIDs[0]->source_name);
	}

	public function testItfindsAnExternalIDValue()
	{
		$value = $this->interface->findExternalIDValue("c9508493bc9e012d1837114659e5dac5", "ViimedSite_1");

		$this->assertEquals("22cf1c14-a59c-3cfa-916f-6095b608c086", $value);
	}

	public function testFindEmrByID()
	{
		$emr = $this->interface->findEmrByID(1);

		$this->assertEquals("Balistreri, Vandervort and West", $emr->name);
	}

	public function testFindPatientByGlobalUserID()
	{
		$patient = $this->interface->findPatientByGlobalUserID("e733674f928911fd3432496ccf7744aa");

		$this->assertEquals("381-02-4237", $patient->ssn);
	}

	public function testSearchForPatientsWhere()
	{
		$dob = new DateTime("2000-05-14"); // Does timezone cause an issue????
		$lname = "YUNDT";
		$ssn = "381-02-4237";
		$gender = "F";

		$patients = $this->interface->searchForPatientsWhere($dob, $lname, $ssn, $gender);

		$this->assertEquals("381-02-4237", $patients[0]->ssn);
		$this->assertCount(1, $patients);
	}
//*/


}