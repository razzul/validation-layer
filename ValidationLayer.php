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
        $success = $this->priority();

        // merge error if there is error in pre validation layer
        if ($success == false) {
            $this->merge_errors($this->pre_errors);
            $this->merge_errors($this->bussiness_errors);
            $this->merge_errors($this->pms_errors);
            $this->merge_errors($this->before_save_errors);
        }
        // validating pre validation layer
        //PreValidationLayer::pre_post_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating bussiness validation layer
        //BussinessValidationLayer::post_bussiness_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating PMS validation layer
        //PMSValidationLayer::post_pms_validation($request_data, $global_contract_id, $global_contract_uuid);
        // validating before save validation layer
        //BeforeSaveValidationLayer::post_save_validation($request_data, $global_contract_id, $global_contract_uuid);

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
        $current_priority_level = 1;
        $advance_to_next_level  = true;
        // validate priority_list
        if (empty($this->priority_list)) {
            echo "Please set priority in config/api_config";die();
        }

        foreach ($this->priority_list as $priority_level => $priority_details) {
            $max_method_count = count($priority_details);
            $has_error        = false;
            foreach ($priority_details as $current_method_index => $method_name) {
                // validate if method dosn't exist in layer
                if (!method_exists($this, $method_name)) {
                    echo "In " . $method_name . " validation layer method " . $method_name . " not exist <br>";die();
                }

                echo "<hr>";
                echo "$priority_level => ";

                $success = null;
                if ($advance_to_next_level == true) {
                    $success = $this->{$method_name}($arguments);
                } else {
                    break;
                }

                if ($success === false) {
                    $has_error = true;
                }

                $current_method_index += 1;

                if ($success === false && $current_priority_level == $priority_level && $current_method_index != $max_method_count) {
                    $advance_to_next_level = true;
                } else if ($success === false && $current_priority_level == $priority_level && $current_method_index == $max_method_count) {
                    $advance_to_next_level = false;
                } else if ($success === true && $current_priority_level == $priority_level && $current_method_index != $max_method_count) {
                    $advance_to_next_level = true;
                } else if ($success === true && $current_priority_level == $priority_level && $current_method_index == $max_method_count) {
                    if ($has_error == false) {
                        $advance_to_next_level = true;
                    } else {
                        $advance_to_next_level = false;
                    }
                } else if ($success === false && $current_priority_level != $priority_level && $current_method_index != $max_method_count) {
                    $advance_to_next_level  = true;
                    $current_priority_level = $priority_level;
                } else if ($success === false && $current_priority_level != $priority_level && $current_method_index == $max_method_count) {
                    $advance_to_next_level = false;
                } else if ($success === true && $current_priority_level != $priority_level && $current_method_index != $max_method_count) {
                    $advance_to_next_level  = true;
                    $current_priority_level = $priority_level;
                } else if ($success === true && $current_priority_level != $priority_level && $current_method_index == $max_method_count) {
                    if ($has_error == false) {
                        $advance_to_next_level = true;
                    } else {
                        $advance_to_next_level = false;
                    }
                } else {
                    $advance_to_next_level = false;
                }

                echo "<hr>";
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
        $this->errors          = array_merge_recursive($this->errors, $errors);
        $this->errors['codes'] = array_unique($this->errors['codes']);
    }
}
