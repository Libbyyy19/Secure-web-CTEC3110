<?php

namespace Telemetry;

class RegisterUser
{

    public function createHtmlOutput($app, $request, $response)
    {
        $tainted_parameters = $request->getParsedBody();

        $view = $app->getContainer()->get('view');
        $validator = $app->getContainer()->get('Validator');
        $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');

        $register_model = $app->getContainer()->get('registerModel');
        $register_view = $app->getContainer()->get('registerUserView');

        $database_connection_settings = $app->getContainer()->get('doctrine_settings');
        $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');

        $cleaned_parameters = $register_model->cleanedupParameters($validator, $tainted_parameters);

        $hashed_password = $register_model->hash_password($bcrypt_wrapper, $cleaned_parameters['password']);

        $storage_result = $register_model->storeUserDetails($database_connection_settings, $doctrine_queries, $cleaned_parameters, $hashed_password);
        $retrieve_result = $register_model->testRetrieve($app, $cleaned_parameters);

        $register_view->createRegisterUserView($view, $response);
    }
}