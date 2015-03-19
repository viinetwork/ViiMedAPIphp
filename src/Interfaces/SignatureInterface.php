<?php namespace Viimed\PhpApi\Interfaces;

interface SignatureInterface {
	public function makeHash($secret, $url, array $query = []);
}