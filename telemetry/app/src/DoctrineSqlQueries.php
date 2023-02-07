<?php

namespace Telemetry;

class DoctrineSqlQueries
{
    public function __construct() { }

    public function __destruct(){ }

    /**
     * @param $queryBuilder
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     * Stores the santised and validated values of the full name and email of the user, then inserts these values within the database to be called upon at a later date
     */
    public static function queryStoreUserData($queryBuilder, array $cleaned_parameters, string $hashed_password)
    {
        $store_result = [];
        $fullname = $cleaned_parameters['sanitised_fullname'];
        $email = $cleaned_parameters['sanitised_email'];

        $queryBuilder = $queryBuilder->insert('user_details')
            ->values([
                'full_name' => ':name',
                'email' => ':email',
                'password' => ':password',
                'role' => ':role',
            ])
            ->setParameters([
                ':name' => $fullname,
                ':email' => $email,
                ':password' => $hashed_password,
                ':role' => 'user'
            ]);

        $store_result['outcome'] = $queryBuilder->execute();
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }

    /**
     * @param $queryBuilder
     * @param array $cleaned_parameters
     * @return mixed
     * Retrieves the user information, such as username and email, for the user to be able to login when previously registered
     */
    public static function queryRetrieveUserDetails($queryBuilder, array $cleaned_parameters)
    {
        $retrieve_result = [];
        $fullname = $cleaned_parameters['sanitised_fullname'];

        $queryBuilder
            ->select('password', 'email')
            ->from('user_details', 'u')
            ->where('full_name = ' . $queryBuilder->createNamedParameter($fullname));

        $query = $queryBuilder->execute();
        $result = $query->fetchAll();

        return $result;
    }
}