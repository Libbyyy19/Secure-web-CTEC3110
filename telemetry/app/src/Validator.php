<?php

namespace Telemetry;

class Validator
{

    public function __construct() { }

    public function __destruct() { }

    /**
     * @param $string_to_sanitise
     * @return string|mixed
     */
    public function sanitiseString($string_to_sanitise): string
    {
        $sanitised_string = false;

        if(!empty($string_to_sanitise)){
            $sanitised_string = filter_var($string_to_sanitise, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    public function validateDownloadedData($tainted_data)
    {
        $validated_string_data = '';

        $validated_string_data = filter_Var($tainted_data, FILTER_SANITIZE_STRING);

        return $validated_string_data;
    }

    public function validateCountryCode($country_code_to_check)
    {
        $checked_country = false;
        if(isset($country_code_to_check))
        {
            if(!empty($country_code_to_check))
            {
                if(strlen($country_code_to_check) == 2)
                {
                    $checked_country = $country_code_to_check;
                }
            }
            else
            {
                $checked_country = 'none inputted';
            }
        }
        return $checked_country;
    }



}