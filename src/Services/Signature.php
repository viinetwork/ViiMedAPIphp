<?php namespace Viimed\PhpApi\Services;

use Viimed\PhpApi\Interfaces\SignatureInterface;

class Signature implements SignatureInterface {

	public function makeHash($secret, $url, array $query = [])
	{
		ksort( $query ); // sort alphabetically

		$fullUrl = empty($query) ? $url : $url . '?' . http_build_query($query);

		return hash_hmac(static::ALGORITHM, $fullUrl, $secret);
	}
}