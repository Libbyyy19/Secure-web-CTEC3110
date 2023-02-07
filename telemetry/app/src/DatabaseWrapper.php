<?php

namespace Telemetry;

use PDO;
use PDOException;

class DatabaseWrapper
{
    private $db_handle;
    private $sql_queries;
    private $prepared_statement;
    private $errors;
    private $database_connection_settings;

    public function __construct()
    {
        $this->db_handle = null;
        $this->sql_queries = null;
        $this->prepared_statement = null;
        $this->errors = [];
    }

    public function __destruct() { }


    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    /**
     * @return string
     * function that creates a PDO connection so a user is able to connect to the database
     */
    public function makeDatabaseConnection()
    {
        $pdo = false;
        $pdo_error = '';

        $database_settings = $this->database_connection_settings;
        $host_name = $database_settings['rdbms'] . ':host=' . $database_settings['host'];
        $port_number = ';port=' . '3306';
        $user_database = ';dbname=' . $database_settings['db_name'];
        $host_details = $host_name . $port_number . $user_database;
        $user_name = $database_settings['user_name'];
        $user_password = $database_settings['user_password'];
        $pdo_attributes = $database_settings['options'];

        try
        {
            $pdo_handle = new \PDO($host_details, $user_name, $user_password, $pdo_attributes);
            $this->db_handle = $pdo_handle;
           // $this->session_logger->notice('successfully connected to database');
        }
        catch (\PDOException $exception_object)
        {
            trigger_error('error connecting to database');
            $pdo_error = 'error connecting to database';
         //   $this->session_logger->warning('Error connecting');
        }

        return $pdo_error;
    }


    public function safeQuery($query_string, $params = null)
    {
        $this->errors['db_error'] = false;
        $query_parameters = $params;

        try
        {
          // $this->prepared_statement = $this->db_handle->prepare($query_string);
          //  $execute_result = $this->prepared_statement->execute($query_parameters);
           // $this->errors['execute-OK'] = $execute_result;
         //   $this->session_logger->notice('successfully connected to database');
        }
        catch (PDOException $exception_object)
        {
            $error_message = 'PDO Exception caught. ';
            $error_message .= 'Error with the database access.' . "\n";
            $error_message .= 'SQL query: ' . $query_string . "\n";
            $error_message .= 'Error: ' . var_dump($this->prepared_statement->errorInfo(), true) . "\n";

            $this->errors['db_error'] = true;
            $this->errors['sql_error'] = $error_message;
        }
        return $this->errors['db_error'];
    }

    /**
     * @return void
     * returns the current amount of rows in the dataset
     */
    public function countRows()
    {
       //$num_rows = $this->prepared_statement->rowCount();
      // return $num_rows;
    }

    /**
     * @return mixed
     * fetches that row of data from the dataset
     */
    public function safeFetchRow()
    {
        $record_set = $this->prepared_statement->fetch(\PDO::FETCH_NUM);
        return $record_set;
    }

    /**
     * @return mixed
     * fetches an array of data from the database/dataset
     */
    public function safeFetchArray()
    {
        $arr_row = $this->prepared_statement->fetch(\PDO::FETCH_ASSOC);
        return $arr_row;
    }

    /**
     * @return mixed
     * returns the ID of the last inserted row in the database
     */
    public function lastInsertedID()
    {
        $sql_query = 'SELECT LAST_INSERT_ID()';

        $this->safeQuery($sql_query);
        $arr_last_inserted_id = $this->safeFetchArray();
        $last_inserted_id = $arr_last_inserted_id['LAST_INSERT_ID()'];
        return $last_inserted_id;
    }

}