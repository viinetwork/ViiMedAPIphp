<?php

// Guzzle\Client constructor configurations...
return [
	'authtokens' => [
		'base_url' => ['https://himss.viinetwork.net/api/{version}/authtokens', ['version' => 'v2']]
	],

	'viiid' => [
		'base_url' => ['https://himss.viinetwork.net/api/{version}/viiid', ['version' => 'v2']]
	],

	'schemas' => [
			'base_url' => ['https://localqa.viinetwork.net/api/{version}', ['version' => 'v2']]
	],
];
