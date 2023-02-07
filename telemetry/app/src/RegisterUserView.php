<?php

namespace Telemetry;

class RegisterUserView
{

    public function __construct(){ }
    public function __destruct(){ }

    public function createRegisterView(
        object $view,
        object $response,
        array $tainted_parameters,
        array $cleaned_parameters,
        array $results
    ): void
    {

        $view->render($response,
            'homepageform.html.twig',
            [
              'landing_page' => $_SERVER["SCRIPT_NAME"],
              'css_path' => CSS_PATH,
              'page_title' => APP_NAME,
                'page_heading_1' => 'New User Registration',
                'fullname' => $tainted_parameters['fullname'],
                'email' => $tainted_parameters['email'],
                'password' => $tainted_parameters['password'],
                'sanitised_fullname' => $cleaned_parameters['sanitised_fullname'],
                'sanitised_email' => $cleaned_parameters['sanitised_email'],
                'cleaned_password' => $cleaned_parameters['password'],
                'hashed_password' => $hashed_password,
                'storage_result' => $storage_result,
            ]);

    }
}