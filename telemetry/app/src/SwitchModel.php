<?php

namespace Telemetry;

class SwitchModel
{

    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

    public function __construct() { }

    public function __destruct() { }


    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function getSwitches()
    {
        $switches = [];

        $query_string = $this->sql_queries->getSwitches();
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->database_wrapper->makeDatabaseConnection();
        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets === 1) {
            while ($row = $this->database_wrapper->safeFetchArray()) {
                $switches['switch1'] = $row['switch1'];
                $switches['switch2'] = $row['switch2'];
                $switches['switch3'] = $row['switch3'];
                $switches['switch4'] = $row['switch4'];
                $switches['fan'] = $row['fan'];
                $switches['heater'] = $row['heater'];
                $switches['keypad'] = $row['keypad'];
            }
    }
        else
        {
            $switch[0] = 'error';
        }
        $switch['retrieved_switch'] = $switches;

        return $switch;
    }

    public function getMessageFromDatabase()
    {
        $query_string = $this->sql_queries->getFromDatabase();
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->database_wrapper->makeDatabaseConnection();
        $this->database_wrapper->safeQuery($query_string);
        $row = $this->database_wrapper->safeFetchArray();

        $messages_details = $row['message'];

        return $messages_details;
    }
}