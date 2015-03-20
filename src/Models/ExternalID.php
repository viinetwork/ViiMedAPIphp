<?php namespace Viimed\PhpApi\Models;

class ExternalID {

	public $SourceIdentifierID;
	public $Value;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($SourceIdentifierID, $Value)
	{
		$this->SourceIdentifierID = $SourceIdentifierID;
		$this->Value = $Value;
	}
}