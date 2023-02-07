<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'], '/login',
        function(Request $request, Response $response) use ($app)
        {
           return $this->view->render($response,
            'login.html.twig',
            [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'page_title' => APP_NAME,
             'method' => 'POST',
            'action' => 'displaytelemetrydata',
            'page_heading_1' => 'Please enter your username and password: ',
                'register_page' => LANDING_PAGE .'/register'

            ]);

        })->setName('login');