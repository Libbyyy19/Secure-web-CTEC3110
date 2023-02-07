<?php

namespace Telemetry;

class downloadmessages
{
   private $download_message;
   private $counter;
   private $database_wrapper;
   private $database_connection_settings;
   private $sql_queries;
   private $soap_response;
    private $soap_wrapper;
    private $detail;
    private $msisdn;
    private $destination;
    private $message;
    private $date;
    private $result;

   public function __construct()
   {
       $this->database_wrapper = null;
       $this->sql_queries = null;
       $this->download_message = array();
       $this->soap_response = null;
       $this->counter = null;
   }

   public function __destruct() { }

    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSoapWrapper($soap_wrapper)
    {
        $this->soap_wrapper = $soap_wrapper;
    }
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

    public function getResult()
    {
        return $this->result;
    }
    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function setSoapResponse($soap_response)
    {
        $this->soap_response = $soap_response;
    }

    public function setParameters($cleaned_parameters)
    {
        $this->msisdn = $cleaned_parameters['msisdn'];
        $this->destination = $cleaned_parameters['destination'];
        $this->message = $cleaned_parameters['message'];
        $this->date = $cleaned_parameters['date'];
    }
    /**
     * @return bool
     * prepares the data within the messages by sanitising and validating them ready to be stored within the database
     * makes sure the data follows the validation rules
     */
    public function prepareMessageData()
    {
        $message_data = [];
        $message = $this->soap_response;
        $validator = new Validator();

        for($x = 0; $x<$this->counter; $x++)
        {
            $message_data['msisdn']['$x'] = $validator->sanitiseString();
            $message_data['destination']['$x'] = $validator->sanitiseString();
            $message_data['date']['$x'] = $validator->sanitiseString();
            $message_data['message']['$x'] = $validator->sanitiseString();
        }
        $this->download_message = $message_data;
        return true;
    }

    /**
     * @return void
     *
     */
    public function messagesToStore()
    {
        for($x = 0; $x<$this->counter; $x++)
        {
            $msisdn = $this->download_message['msisdn'][$x++];
            $destination = $this->download_message['destination'][$x++];
            $date = $this->download_message['date'][$x++];
            $message = $this->download_message['message'][$x++];

            $query_parameters = array(
                ':msisdn' => $msisdn,
                ':destination' => $destination,
                ':date' => $date,
                ':message' => $message
            );
            $sql_query_messages = $this->sql_queries->storeMessages();
            $this->database_wrapper->safeQuery($sql_query_messages, $query_parameters);
        }
    }

    /**
     * @return string
     * adds the messages to the database to be called upon later
     */
    public function addMessagesToDatabase()
    {
        $this->messagesToStore();
        if($this->prepareMessageData() == true)
        {
            $this->messagesToStore();
        }
        else
        {
            $result = 'Error';
        }
        return $result;
    }

    public function performDataRetrieval()
    {
        $soapresult = null;

        $soap_client_handle = $this->soap_wrapper->createSoapClient();
        if ($soap_client_handle != false)
        {
            $webservice_parameters = $this->selectDetail();
            $webservice_function = $webservice_parameters['required'];
            $webservice_call_parameters = $webservice_parameters['parameters'];
            $webservice_object_name = $webservice_parameters['result'];

            $soapcall_result = $this->soap_wrapper->performSoapCall($soap_client_handle, $webservice_function, $webservice_call_parameters, $webservice_object_name);

            $this->result = $soapcall_result;
        }
    }

    public function selectDetail()
    {
        $select_detail = [];
        switch($this->detail)
        {
            case 'msisdn':
                $select_detail['required'] = 'msisdn';
                $select_detail['service_parameters'] =
                    [
                        'msisdn' => $this->msisdn
                    ];
                $select_detail['result'] = 'msisdn';
                break;
            case 'destination':
                $select_detail['required'] = 'destination';
                $select_detail['service_parameters'] =
                    [
                        'destination' => $this->destination
                    ];
                $select_detail['result'] = 'destination';
                break;
            case 'message':
                $select_detail['required'] = 'message';
                $select_detail['service_parameters'] =
                    [
                        'message' => $this->message
                    ];
                $select_detail['result'] = 'message';
                break;
            case 'date':
                $select_detail['required'] = 'date';
                $select_detail['service_parameters'] =
                    [
                        'date' => $this->date
                    ];
                $select_detail['result'] = 'date';
                break;
            default:
        }
        return $select_detail;
    }
}
