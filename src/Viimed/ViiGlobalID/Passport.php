<?php namespace Viimed\ViiGlobalID;

use GuzzleHttp\Client as Http;

class Passport {

	protected static $base_url = 'http://viiidservice.app:8000/';

	public static function connect($base_url = NULL)
	{
		$base_url = is_null($base_url) ? static::$base_url : $base_url;

		$http = new Http(['base_url' => $base_url]);

		return new Gateways\Gateway($http);
	}
}