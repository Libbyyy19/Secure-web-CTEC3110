<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'], '/downloaddata',
    function(Request $request, Response $response) use ($app)
    {
        $counter = downloadMessages($app)['counter'];
        $telemetry_data = retrieveMessages($app)['retrieved'];

        return $this->view->render($response,
            'displayresult.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'method' => 'post',
                'action' => 'displayresult',
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'Display telemetry data',
                'telemetry_data' => $telemetry_data,
                'route' => 'displayresult',
            ]);


    })->setName('downloaddata');


function setDatabaseWrapper($app)
{
    return $app->getContainer()->get('DatabaseWrapper');
}

function setQueries($app)
{
    return $app->getContainer()->get('SQLQueries');
}

function setSettings($app)
{
    return $app->getContainer()->get('settings');
}
function downloadMessages($app)
{

    $download_model = $app->getContainer()->get('downloadmessages');
    $soap_wrapper = $app->getContainer()->get('soapwrapper');
    $download_model->setSoapWrapper($soap_wrapper);
    $soap_response = $soap_wrapper->performSoapCall($soap_wrapper->createSoapClient(), MESSAGES_COUNTER);


    $download_model->setSqlQueries(setQueries($app));
    $download_model->setDatabaseConnectionSettings(setSettings($app)['pdo_settings']);
    $download_model->setDatabaseWrapper(setDatabaseWrapper($app));
    // $download_model->setCounter($counter);
    $download_model->setSoapResponse($soap_response);

    $downloaded_messages['download'] = $download_model->addMessagesToDatabase();

    return $downloaded_messages;

}

function retrieveMessages($app)
{
    $messagesmodel = $app->getContainer()->get('Messages');
    $messagesmodel->setSqlQueries(setQueries($app));
    $messagesmodel->setDatabaseConnectionSettings(setSettings($app)['pdo_settings']);
    $messagesmodel->setDatabaseWrapper(setDatabaseWrapper($app));

    $messages_data = $messagesmodel->fetchMessages();

    return $messages_data;
}