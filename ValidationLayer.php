<?php
/**
 * Validation Layers
 */
require_once __DIR__ . '/layers/PreValidationLayer.php';
require_once __DIR__ . '/layers/BussinessValidationLayer.php';
require_once __DIR__ . '/layers/PMSValidationLayer.php';
require_once __DIR__ . '/layers/BeforeSaveValidationLayer.php';
/**
 * Api Validation Helper
 */
require_once __DIR__ . '/helpers/ApiValidationHelper.php';

/**
 * Validation layer
 */
class ValidationLayer
{
    use PreValidationLayer, BussinessValidationLayer, PMSValidationLayer, BeforeSaveValidationLayer;

    public function __construct()
    {
        $this->errors = array(
            'codes'    => array(),
            'messages' => array(),
        );

        // generating priority list from config/api_config
        $this->priority_list = ApiValidationHelper::generate_priority_list();
        // generating priority list from config/api_config
        $this->priority_level = ApiValidationHelper::generate_priority_level();
    }

    /**
     * Validate POST xml data
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     * @return array
     */
    public function validatePOSTXMLData($request_data, $global_contract_id, $global_contract_uuid)
    {
        // validating pre validation layer
        PreValidationLayer::pre_post_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating bussiness validation layer
        BussinessValidationLayer::post_bussiness_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating PMS validation layer
        PMSValidationLayer::post_pms_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating before save validation layer
        BeforeSaveValidationLayer::post_save_validation($request_data, $global_contract_id, $global_contract_uuid);

        echo "<pre>";
        print_r($this->errors);
    }

    /**
     * Validate POST Version Up xml data
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     * @return array
     */
    public function validateVersionUpPOSTXMLData($request_data, $global_contract_id, $global_contract_uuid)
    {
        // validating pre validation layer
        PreValidationLayer::pre_versionup_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating bussiness validation layer
        BussinessValidationLayer::versionup_bussiness_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating PMS validation layer
        PMSValidationLayer::versionup_pms_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating before save validation layer
        BeforeSaveValidationLayer::versionup_save_validation($request_data, $global_contract_id, $global_contract_uuid);
    }

    /**
     * Validate PATCH xml data
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     * @return array
     */
    public function validatePATCHXMLData($request_data, $global_contract_id, $global_contract_uuid)
    {
        // validating pre validation layer
        PreValidationLayer::pre_patch_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating bussiness validation layer
        BussinessValidationLayer::patch_bussiness_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating PMS validation layer
        PMSValidationLayer::patch_pms_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating before save validation layer
        BeforeSaveValidationLayer::patch_save_validation($request_data, $global_contract_id, $global_contract_uuid);
    }

    /**
     * Magic method to call method dynamically according to the priority set in config/api_config
     * @param $name string
     * @param $arguments array
     */
    public function __call($name, $arguments)
    {
        // validate priority_list
        if (empty($this->priority_list)) {
            echo "Please set priority in config/api_config";die();
        }

        foreach ($this->priority_list as $priority_level => $priority_list) {
            // validate priority level from $arguments
            if (empty($arguments[0])) {
                echo "Calling undefined priority level.";die();
            }
            // validate priority layer from $arguments
            if (empty($arguments[1])) {
                echo "Calling undefined priority layer";die();
            }

            if ($priority_level == $arguments[0]) {
                foreach ($priority_list as $layer => $priorities) {
                    if ($layer == $arguments[1]) {
                        foreach ($priorities as $priority) {
                            // validate if method dosn't exist in layer
                            if (!method_exists($this, $priority)) {
                                echo "In " . $layer . " validation layer method " . $priority . " not exist <br>";die();
                            }
                            $this->{$priority}($arguments[0]);
                        }
                    }
                }
            }
        }
    }

    /**
     * merge errors details
     * @param $errors array
     */
    public function merge_errors($errors, $layer = '')
    {
        if (empty($errors)) {
            return true;
        }
        $this->errors = array_merge_recursive($this->errors, $errors);
        $this->errors['codes'] = array_unique($this->errors['codes']);
    }
}
