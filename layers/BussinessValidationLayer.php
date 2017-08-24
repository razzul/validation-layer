<?php

trait BussinessValidationLayer
{

    /**
     * bool Bussiness validation layer has errors
     */
    public $has_error;
    
    /**
     * array Bussiness validation layer error details
     */
    public $bussiness_errors;

    /**
     * validate POST xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function post_bussiness_validation()
    {
        // validate priority level 1
        $this->priority('9', 'bussiness');

        // merge error if there is error in pre validation layer
        if ($this->has_error) {
            $this->merge_errors($this->bussiness_errors, 'bussiness');
        }
    }

    /**
     * validate POST Version Up xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function versionup_bussiness_validation()
    {
        // validate versionup
    }

    /**
     * validate PATCH xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function patch_bussiness_validation()
    {
        // validate patch
    }

    public function bussiness_mandatory_contract_id($value = '')
    {
        $xpath_ids = ['contract_id' => 'e3e94f9d-0000-4000-af72-7661189fa0f4'];
        $error     = ApiValidationHelper::generate_error('contract_id', $xpath_ids);

        if (!empty($error)) {
            $this->has_error                                     = true;
            $this->bussiness_errors['codes'][]                   = $error['codes'];
            $this->bussiness_errors['messages'][$error['codes']][] = $error['messages'];
        }
    }

    public function bussiness_mandatory_contract_name($value = '')
    {
        $xpath_ids = ['contract_name' => 'e3e94f9d-0000-4000-af72-7661189fa0f4'];
        $error     = ApiValidationHelper::generate_error('contract_name', $xpath_ids);

        if (!empty($error)) {
            $this->has_error                                     = true;
            $this->bussiness_errors['codes'][]                   = $error['codes'];
            $this->bussiness_errors['messages'][$error['codes']][] = $error['messages'];
        }
    }

    public function bussiness_mandatory_bi_action($value='')
    {
        $xpath_ids = array(
            'bi_action' => 'e3e94f9d-0000-4000-af72-7661189fa0f4',
        );
        $error = ApiValidationHelper::generate_error('bi_action', $xpath_ids);
        if (!empty($error)) {
            $this->has_error                                     = true;
            $this->bussiness_errors['codes'][]                   = $error['codes'];
            $this->bussiness_errors['messages'][$error['codes']][] = $error['messages'];
        }
    }
}
