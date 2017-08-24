<?php

trait PMSValidationLayer
{

    /**
     * bool PMS validation layer has errors
     */

    public $has_error;
    /**
     * array PMS validation layer error details
     */
    public $pms_errors;

    /**
     * validate POST xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function post_pms_validation($request_data, $global_contract_id, $global_contract_uuid)
    {
        // validate priority level 1
        $this->priority('1', 'pms');

        // merge error if there is error in pre validation layer
        if ($this->has_error) {
            $this->merge_errors($this->pms_errors);
        }
    }

    /**
     * validate POST Version Up xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function versionup_pms_validation()
    {
        // validate versionup
    }

    /**
     * validate PATCH xml request
     * @param $request_data array
     * @param $global_contract_id string
     * @param $global_contract_uuid string
     */
    public function patch_pms_validation()
    {
        // validate patch
    }

    public function pms_mandatory_characteristic_id($value = '')
    {
        $xpath_ids = array('characteristic_id' => 'e3e94f9d-0000-4000-af72-7661189fa0f4');
        $error     = ApiValidationHelper::generate_error('characteristic_id', $xpath_ids);

        if (!empty($error)) {
            $this->has_error             = true;
            $this->pms_errors['codes'][] = $error['codes'];

            $this->pms_errors['messages'][$error['codes']][] = $error['messages'];
        }
    }
}
