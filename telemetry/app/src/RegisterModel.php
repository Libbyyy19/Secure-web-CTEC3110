<?php

namespace Telemetry;

use Doctrine\DBAL\DriverManager;

class RegisterModel
{

    public function __construct(){ }

    public function __destruct(){ }

    function cleanupParameters($validator, $tainted_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_fullname = $tainted_parameters['fullname'];
        $tainted_email = $tainted_parameters['email'];
        $tainted_phone = $tainted_parameters['phone'];

        $cleaned_parameters['password'] = $tainted_parameters['password'];
        $cleaned_parameters['sanitised_fullname'] = $validator->sanitiseString($tainted_fullname);
        $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);
        $cleaned_parameters['sanitised_phone'] = $validator->sanitisePhone($tainted_phone);
        return $cleaned_parameters;
    }

    /**
     * @param $app
     * @param $password_to_hash
     * @return string
     */

    function hash_password($bcrypt_wrapper, $password_to_hash): string
    {
        $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
        return $hashed_password;
    }

    /**
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */

    function storeUserDetails($database_connection_settings, $doctrine_queries, array $cleaned_parameters, string $hashed_password): string
    {
        $store_result = [];
        $store_result = '';

        $database_connection = DriverManager::getConnection($database_connection_settings);
        $queryBuilder = $database_connection->createQueryBuilder();
        $storage_result = $doctrine_queries::queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password);

        if($storage_result['outcome'] == 1)
        {
            $store_result = 'Data was successfully stored';
        }
        else
        {
            $store_result = 'Error';
        }
        return $store_result;

    }
}