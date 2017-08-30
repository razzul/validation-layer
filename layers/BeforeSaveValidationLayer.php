<?php
require_once __DIR__ . '/../helpers/ApiValidationHelper.php';

trait BeforeSaveValidationLayer
{
    /**
     * bool Before Save validation layer has errors
     */
    public $has_error;

    /**
     * array Before Save validation layer error details
     */
    public $before_save_errors;

    /**
     * validate POST xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function post_save_validation()
    {
        
    }

    /**
     * validate POST Version Up xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function versionup_save_validation()
    {
        // validate POST Version Up
    }

    /**
     * validate PATCH xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function patch_save_validation()
    {
        // validate patch
    }
}
