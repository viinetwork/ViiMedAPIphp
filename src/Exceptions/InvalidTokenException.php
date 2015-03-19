<?php namespace Viimed\PhpApi\Exceptions;

class InvalidTokenException extends RequestException {
	const FAILED = "Token failed validation.";
}