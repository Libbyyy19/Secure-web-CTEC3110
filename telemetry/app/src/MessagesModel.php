<?php

namespace Telemetry;


class messagesModel
{
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

    public function __construct()
    {

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

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    /**
     * @return array
     * makes a connection to the database and retrieves the messages stored from it
     */
    public function fetchMessages()
    {
        $messages = [];
        $query_string = $this->sql_queries->getMessages();
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->database_wrapper->makeDatabaseConnection();
        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if($number_of_data_sets >= 0){
            $lcv = 0;

            while ($lcv < $number_of_data_sets)
            {
                $row = $this->database_wrapper->safeFetchArray();

                $lastmessage[$lcv]['id'] = $row['id'];
                $lastmessage[$lcv]['msisdn'] = $row['msisdn'];
                $lastmessage[$lcv]['destination'] = $row['destination'];
                $lastmessage[$lcv]['date'] = $row['date'];
                $lastmessage[$lcv]['message'] = $row['message'];

                $lcv++;
            }
        }
        else
        {
            $messages[0] = 'No Data found in database';
        }

        $messages['number_of_data_sets'] = $number_of_data_sets;
        $messages['retrieved'] = $lastmessage;

        return $messages;
    }

    /**
     * @return mixed
     * gets the latest message within the database
     */
    public function getLatestMessage()
    {
        $query_string = $this->sql_queries->getLatestMessage();
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->database_wrapper->makeDatabaseConnection();
        $this->database_wrapper->safeQuery($query_string);
        $row = $this->database_wrapper->safeFetchArray();
        $message_data = $row['message'];
        return $message_data;
    }
}