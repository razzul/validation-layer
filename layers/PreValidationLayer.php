<?php

trait PreValidationLayer
{
    /**
     * bool pre validation layer has errors
     */
    public $has_error;

    /**
     * array pre validation layer error details
     */
    public $pre_errors;

    /**
     * validate POST xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function pre_post_validation($request_data, $global_contract_id, $global_contract_uuid)
    {
        // validate priority level 1
        $this->priority('1', 'pre');

        // merge error if there is error in pre validation layer
        if ($this->has_error) {
            $this->merge_errors($this->pre_errors);
        }
    }

    /**
     * validate POST Version Up xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function pre_versionup_validation()
    {
        // validate versionup
    }

    /**
     * validate PATCH xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function pre_patch_validation()
    {
        // validate patch
    }

    public function pre_invalid_http_method($value = '')
    {
        $xpath_ids = ['http_method' => 'PUT'];
        $error     = ApiValidationHelper::generate_error('http_method', $xpath_ids, 'invalid');

        if (!empty($error)) {
            $this->has_error             = true;
            $this->pre_errors['codes'][] = $error['codes'];

            $this->pre_errors['messages'][$error['codes']][] = $error['messages'];
        }
    }

    public function pre_invalid_session($value = '')
    {
        $xpath_ids = ['session' => 'e3e94f9d-0000-4000-af72-7661189fa0f4'];
        $error     = ApiValidationHelper::generate_error('session', $xpath_ids, 'invalid');

        if (!empty($error)) {
            $this->has_error             = true;
            $this->pre_errors['codes'][] = $error['codes'];

            $this->pre_errors['messages'][$error['codes']][] = $error['messages'];
        }
    }
}
