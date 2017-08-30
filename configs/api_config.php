<?php

global $api_config;

// priority 1
$api_config['xpath'][] = [
	// group A
	[
		'http_method' => [
			'type'     => 'invalid',
			'layer'    => 'pre',
			'code'     => '4050101001',
			'message'  => 'Invalid HTTP Method.',
			'details'  => 'HTTP method "{http_method}" is invalid for "api/v2/contract-information"',
		],
	],
];

// priority 2
$api_config['xpath'][] = [
	// group B
	[
		'session' => [
			'type'     => 'invalid',
			'layer'    => 'pre',
			'code'     => '4000201001',
			'message'  => 'Invalid Session Id.',
			'details'  => '',
		]
	]
];

// priority 3
$api_config['xpath'][] = [];

// priority 4
$api_config['xpath'][] = [
	// group A
	[
		'contract_id' => [
			'type'     => 'mandatory',
			'layer'    => 'bussiness',
			'code'     => '4050101001',
			'message'  => 'Contract process terminated. Contract Reference ID (GCM ID or Contract UUID) should not be empty.',
			'details'  => '"bi:contract-id" prarameter is mandatory.',
		]
	],
	// group B
	[
		'contract_name' => [
			'type'     => 'mandatory',
			'layer'    => 'bussiness',
			'code'     => '4000201001',
			'message'  => 'Contract process terminated. Mandatory element(s) should not be empty.',
			'details'  => '/contract-info:contract-information/bi:product-contracts/bi:product-contract [@id="{contract_name}:1"]/cbe:name is mandatory.',
		]
	]
];

// priority 5
$api_config['xpath'][] = [];

// priority 6
$api_config['xpath'][] = [];

// priority 7
$api_config['xpath'][] = [];

// priority 8
$api_config['xpath'][] = [];

// priority 9
$api_config['xpath'][] = [
	// group B
	[
		'characteristic_id' => [
			'type'     => 'mandatory',
			'layer'    => 'pms',
			'code'     => '4000201001',
			'message'  => 'Contract process terminated. Mandatory element(s) should not be empty.',
			'details'  => '/contract-info:contract-information/bi:product-biitems/bi:product-biitem [@id="{characteristic_id}:1"] characteristic is mandatory.',
		],

		'bi_action' => [
			'type'     => 'mandatory',
			'layer'    => 'bussiness',
			'code'     => '4000201001',
			'message'  => 'Contract process terminated. Mandatory element(s) should not be empty.',
			'details'  => 'Biitem "bi:action" XPATH with [@id/temporary-id="{bi_action}"]+ is mandatory.',
		]
	]
];