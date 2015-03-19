<?php namespace Viimed\PhpApi\Interfaces;

interface AuthServiceInterface {
	public function generateToken($Identifier, $IdentifierID);
	public function validateToken($Token, $Identifier, $IdentifierID);
	public function destroyToken($Token);
}