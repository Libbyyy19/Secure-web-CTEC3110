<?php

namespace Telemetry;


use PhpParser\Node\Stmt\Echo_;

class soapwrapper
{

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return \SoapClient|string
     * creates a soap call request to the web API
     */
    public function createSoapClient()
    {
        $soap_client_parameters = array();
        $soap_client_handle = false;
        $wsdl = WSDL;
        $soap_client_parameters = ['trace' => true, 'exception' => true];

        try {
            $soap_client_handle = new \SoapClient($wsdl, $soap_client_parameters);
        } catch (\SoapFault $exception) {
            $soap_client_handle = 'error';
        }
        return $soap_client_handle;
    }

    /**
     * @param $soap_client
     * @param $counter
     * @return mixed|null
     *
     */
    public function performSoapCall($soap_client, $counter)
    {
        $soap_call_result = null;
        $user = SMSUSER;
        $pass = SMSPASS;

        if($soap_client) {
            try {
                $soap_call_result = $soap_client->peekMesssages($user, $pass, $counter, "");
            }
            catch (\SoapFault $exception)
            {
                echo 'performSoapCall : error';
            }
        }
        return $soap_call_result;
    }

}