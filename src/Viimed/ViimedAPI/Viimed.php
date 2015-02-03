<?php namespace Viimed\ViimedAPI;

use GuzzleHttp\Client as Http;


/**
 * Gateway Factory class
 */
class Viimed {

	const BASE_URL = 'https://gwn-demo.viinetwork.net/';

	public static function connect($ViiPartnerID, $ViiPartnerSecret, $ViiClientID)
	{
		$http = new Http(['base_url' => static::BASE_URL]);

		return new Gateway($http, $ViiPartnerID, $ViiPartnerSecret, $ViiClientID);
	}
}