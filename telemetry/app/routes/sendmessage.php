<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'], '/sendmessage',
    function(Request $request, Response $response) use ($app)
    {

        $html_output =  $this->view->render($response,
            'sendMessages.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'page_title' => 'Send Message',
                'sendmessage' => 'sendMessage',
                'message_result' => 'Message Sent',
                'homepage' => LANDING_PAGE . '/homepage',
                'send_another_message' => LANDING_PAGE . 'sendmessage',
                'method' => 'post',

            ]);

       return $html_output;

    })->setName('sendmesssage');

function sendMessage($app)
{
    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $messagesmodel = $app->getContainer()->get('messagesModel');
    $messagesmodel->setSoapWrapper($soap_wrapper);

    $messagesmodel->sendMessage();
}

