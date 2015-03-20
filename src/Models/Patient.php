<?php namespace Viimed\PhpApi\Models;

use DateTime;

class Patient {
	
	public $globaluser_id;
	public $lname;
	public $dob;
	public $gender;
	public $ssn;
	public $fname;
	public $mname;
	public $alias;
	public $birth_city;
	public $birth_state;
	public $birth_country;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($globaluser_id, $lname, DateTime $dob, $gender, $ssn = NULL, $fname = NULL, $mname = NULL, $alias = NULL, $birth_city = NULL, $birth_state = NULL, $birth_country = NULL)
	{
		$this->globaluser_id = $globaluser_id;
		$this->lname = $lname;
		$this->dob = $dob;
		$this->gender = $gender;
		$this->ssn = $ssn;
		$this->fname = $fname;
		$this->mname = $mname;
		$this->alias = $alias;
		$this->birth_city = $birth_city;
		$this->birth_state = $birth_state;
		$this->birth_country = $birth_country;
	}
}