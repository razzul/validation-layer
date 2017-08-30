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

        $xpath_details = ApiValidationHelper::get_xpath_details($xpath, $xpath_ids);
        // validate xpath details avilable in config/api_config
        if (empty($xpath_details)) {
            return false;
        }
        // validate xpath code avilable in config/api_config
        if (empty($xpath_details['code'])) {
            return false;
        }
        // validate xpath code avilable in config/api_config
        if (empty($xpath_details['message'])) {
            return false;
        }

        $error_details['codes']    = $xpath_details['code'];
        $error_details['messages'] = $xpath_details['message'];

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

        foreach ($api_config['xpath'] as $priority_level => $priority_details) {
            foreach ($priority_details as $group_level => $group_details) {
                foreach ($group_details as $field_name => $field_details) {
                    $priority_list[$priority_level + 1][] = $field_details['layer'] . '_' . $field_details['type'] . '_' . $field_name;
                }
            }
        }

        return $priority_list;
    }

    public static function get_xpath_details($name, $xpath_ids)
    {
        global $api_config;
        $xpath_details = '';

        if (empty($name) || !is_array($xpath_ids)) {
            return false;
        }

        foreach ($api_config['xpath'] as $priority_level => $priority_details) {
            foreach ($priority_details as $group_level => $group_details) {
                foreach ($group_details as $field_name => $field_details) {

                    if ($field_name == $name) {
                        $xpath = trim($field_details['message']) . ' ' . trim($field_details['details']);

                        foreach ($xpath_ids as $xpath_name => $xpath_details) {
                            $search       = '{' . $xpath_name . '}';
                            $replace_with = $xpath_details;

                            $xpath .= str_replace($search, $replace_with, $field_details['details']);
                        }

                        $xpath_details = [
                            'code'    => $field_details['code'],
                            'message' => $xpath,
                        ];
                    }

                }
            }
        }

        return $xpath_details;
    }
}
