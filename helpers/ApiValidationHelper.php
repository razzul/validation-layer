<?php

require_once __DIR__ . '/../configs/api_config.php';

/**
 * Api Validation Helper
 */
class ApiValidationHelper
{

    /**
     * generate error details with dynamic xpath from config/api_config
     * @param $xpath string name of the xpath key
     * @param $xpath_ids array key value pairs of xpath ids which going to replace with
     * @param $type string xpath category [mandatory|invalid]
     * @return array
     */
    public static function generate_error($xpath, $xpath_ids = [], $type = 'mandatory')
    {
        global $api_config;
        $error_details = [];
        // validate xpath name or ids empty
        if (!empty($xpath) && !is_array($xpath_ids)) {
            return false;
        }

        $xpath_details = $api_config['xpath'][$type][$xpath];
        // validate xpath details avilable in config/api_config
        if (empty($xpath_details)) {
            return false;
        }
        // validate xpath code avilable in config/api_config
        if (empty($xpath_details['code'])) {
            return false;
        }

        $message = $xpath_details['message'];
        if (!empty($xpath_ids)) {
            foreach ($xpath_ids as $xpath_key => $xpath_value) {
                // validate xpath details avilable in config/api_config
                if (empty($xpath_details['details']) && empty($xpath_key) && empty($xpath_value)) {
                    return false;
                }

                $search       = "{" . $xpath_key . "}";
                $replace_with = $xpath_value;
                $message .= str_replace($search, $replace_with, $xpath_details['details']);
            }
        }

        $error_details['codes']    = $xpath_details['code'];
        $error_details['messages'] = $message;

        return $error_details;
    }

    /**
     * generate priority list from config/api_config
     * @return array
     */
    public static function generate_priority_list()
    {
        global $api_config;
        $priority_list = [];
        // retrive invalid priority list from config/api_config
        foreach ($api_config['xpath']['invalid'] as $key => $value) {
            $priority_list[$value['priority']][$value['layer']][] = $value['layer'] .'_invalid_'. $key;
        }
        // retrive mandatory priority list from config/api_config
        foreach ($api_config['xpath']['mandatory'] as $key => $value) {
            $priority_list[$value['priority']][$value['layer']][] = $value['layer'] .'_mandatory_'. $key;
        }
        
        return $priority_list;
    }

    /**
     * generate priority level from config/api_config
     * @return array
     */
    public static function generate_priority_level()
    {
        global $api_config;
        $priority_level = [];
        // retrive invalid priority list from config/api_config
        foreach ($api_config['xpath']['invalid'] as $key => $value) {
            $priority_level[$value['layer']][] = $value['priority'];
        }
        // retrive mandatory priority list from config/api_config
        foreach ($api_config['xpath']['mandatory'] as $key => $value) {
            $priority_level[$value['layer']][] = $value['priority'];
        }

        $data = [];
        foreach ($priority_level as $key => $value) {
            $data[$key] = array_unique($value);
        }

        return $data;
    }
}
