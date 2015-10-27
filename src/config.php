<?php

// Guzzle\Client constructor configurations...
return [
	'authtokens' => [
		'base_url' => ['https://localhost.viinetwork.net/api/{version}/authtokens', ['version' => 'v2']]
	],

	'viiid' => [
		'base_url' => ['https://localhost.viinetwork.net/api/{version}/viiid', ['version' => 'v2']]
	],

	'schemas' => [
		'base_url' => ['https://localhost.viinetwork.net/api/{version}', ['version' => 'v2']]
	],

	'identity' => [
		'base_url' => ['https://localhost.viinetwork.net/api/{version}/identity', ['version' => 'v2']]
	],

	'hcpcs' => [
		'base_url' => ['https://localhost.viinetwork.net/api/{version}/hcpcs', ['version' => 'v2']]
	],

	'ingestion' => [
		'base_url' => ['https://localhost.viinetwork.net/api/{version}/messages/post', ['version' => 'v2']]
	],

        'saml' => [
                'base_url' => ['https://localhost.viinetwork.net/api/{version}/{prefix}', ['version' => 'v2', 'prefix' => 'sso']]
        ],
];
