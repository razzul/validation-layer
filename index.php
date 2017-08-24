<?php 

require_once __DIR__ . '/ValidationLayer.php';


$request_data = [];
$global_contract_id = null;
$global_contract_uuid = null;

$validation = new ValidationLayer();
$validation->validatePOSTXMLData($request_data, $global_contract_id, $global_contract_uuid);