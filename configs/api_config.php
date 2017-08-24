<?php

global $api_config;

#######################
### mandatory xpath ###
#######################

/**
 * XPATH for mandatory bi:contract-id.
 */
$api_config['xpath']['mandatory']['contract_id']['priority'] = '4';
$api_config['xpath']['mandatory']['contract_id']['layer']    = 'bussiness';
$api_config['xpath']['mandatory']['contract_id']['code']     = '4050101001';
$api_config['xpath']['mandatory']['contract_id']['message']  = 'Contract process terminated. Contract Reference ID (GCM ID or Contract UUID) should not be empty.';
$api_config['xpath']['mandatory']['contract_id']['details']  = '"bi:contract-id" prarameter is mandatory.';

/**
 * XPATH for mandatory contract-name.
 */
$api_config['xpath']['mandatory']['contract_name']['priority'] = '4';
$api_config['xpath']['mandatory']['contract_name']['layer']    = 'bussiness';
$api_config['xpath']['mandatory']['contract_name']['code']     = '4000201001';
$api_config['xpath']['mandatory']['contract_name']['message']  = 'Contract process terminated. Mandatory element(s) should not be empty.';
$api_config['xpath']['mandatory']['contract_name']['details']  = '/contract-info:contract-information/bi:product-contracts/bi:product-contract [@id="{contract_name}:1"]/cbe:name is mandatory.';

/**
 * XPATH for mandatory characteristic id.
 */
$api_config['xpath']['mandatory']['characteristic_id']['priority'] = '9';
$api_config['xpath']['mandatory']['characteristic_id']['layer']    = 'pms';
$api_config['xpath']['mandatory']['characteristic_id']['code']     = '4000201001';
$api_config['xpath']['mandatory']['characteristic_id']['message']  = 'Contract process terminated. Mandatory element(s) should not be empty.';
$api_config['xpath']['mandatory']['characteristic_id']['details']  = '/contract-info:contract-information/bi:product-biitems/bi:product-biitem [@id="{characteristic_id}:1"] characteristic is mandatory.';

/**
 * XPATH for mandatory bi:action.
 */
$api_config['xpath']['mandatory']['bi_action']['priority'] = '9';
$api_config['xpath']['mandatory']['bi_action']['layer']    = 'bussiness';
$api_config['xpath']['mandatory']['bi_action']['code']     = '4000201001';
$api_config['xpath']['mandatory']['bi_action']['message']  = 'Contract process terminated. Mandatory element(s) should not be empty.';
$api_config['xpath']['mandatory']['bi_action']['details']  = 'Biitem "bi:action" XPATH with [@id/temporary-id="{bi_action}"]+ is mandatory.';

#####################
### invalid xpath ###
#####################

/**
 * XPATH for invalid HTTP Method.
 */
$api_config['xpath']['invalid']['http_method']['priority'] = '1';
$api_config['xpath']['invalid']['http_method']['layer']    = 'pre';
$api_config['xpath']['invalid']['http_method']['code']     = '4050101001';
$api_config['xpath']['invalid']['http_method']['message']  = 'Invalid HTTP Method.';
$api_config['xpath']['invalid']['http_method']['details']  = 'HTTP method "{http_method}" is invalid for "api/v2/contract-information" ';

/**
 * XPATH for invalid session.
 */
$api_config['xpath']['invalid']['session']['priority'] = '1';
$api_config['xpath']['invalid']['session']['layer']    = 'pre';
$api_config['xpath']['invalid']['session']['code']     = '4010101001';
$api_config['xpath']['invalid']['session']['message']  = 'Invalid Session Id.';
$api_config['xpath']['invalid']['session']['details']  = '';
