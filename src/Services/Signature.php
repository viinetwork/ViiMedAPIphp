<?php namespace Viimed\PhpApi\Services;

use Viimed\Contracts\Services\SignatureInterface;

class Signature implements SignatureInterface {

	const ALGORITHM = 'sha1';

	public function makeHash($secret, $url, array $query = [])
	{
		$url = rtrim($url, '/');

		ksort( $query ); // sort alphabetically

		$fullUrl = empty($query) ? $url : $url . '?' . http_build_query($query);

		return hash_hmac(static::ALGORITHM, $fullUrl, $secret);
	}
}