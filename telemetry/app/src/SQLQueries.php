<?php

namespace Telemetry;

class SQLQueries
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function getMessages()
    {
        $query_string = "SELECT id, msisdn, destination, date, message ";
        $query_string .= "FROM message_data ";
        $query_string .= "WHERE date != '' ";
        $query_string .= "ORDER BY id desc ";
        return $query_string;
    }

    public function storeMessages()
    {
        $query_string = 'INSERT INTO message_data (id, msisdn, destination, date, message) VALUES (NULL, :msisdn, :destination, :date, :message);';
        return $query_string;
    }

    public function getSwitches()
    {
        $query_string = "SELECT switch1, switch2, switch3, switch4, fan, heater, keypad ";
        $query_string .= "FROM  telemetry_db, telemetry_data ";
        $query_string .= "WHERE switch1 ";
        $query_string .= "ORDER BY switch1 desc ";
        return $query_string;
    }
}