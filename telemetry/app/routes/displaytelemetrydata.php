<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->map(['GET', 'POST'], '/displaytelemetrydata',
    function(Request $request, Response $response) use ($app)
    {
        downloadMessages($app);

        $switch_data = checkSwitchState($app)['get'];

        $switch1 = $switch_data['switch1'];
        $switch2 = $switch_data['switch2'];
        $switch3 = $switch_data['switch3'];
        $switch4 = $switch_data['switch4'];
        $fan = $switch_data['fan'];
        $heater = $switch_data['heater'];
        $keypad = $switch_data['keypad'];


            return $this->view->render($response,
            'displayTelemetrydata.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'initial_input_box_value' => null,
                'page_heading' => APP_NAME,
                'page_title' => APP_NAME . ' Telemetry Data',
                'method' => 'post',
                'switch1' => $switch1,
                'switch2' => $switch2,
                'switch3' => $switch3,
                'switch4' => $switch4,
                'fan' => $fan,
                'heater' => $heater,
                'keypad' => $keypad,
                'route' => 'displaytelemetrydata',
            ]);

    })->setName('TelemetryData');

function checkSwitchState($app)
{
    $messagesmodel = $app->getContainer()->get('Messages');
    $switchmodel = $app->getContainer()->get('SwitchModel');
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $settings = $app->getContainer()->get('settings');
    $database_connection_settings = $settings['pdo_settings'];

    $messagesmodel->setSqlQueries($sql_queries);
    $messagesmodel->setDatabaseConnectionSettings($database_connection_settings);
    $messagesmodel->setDatabaseWrapper($database_wrapper);

    $switchmodel->setSqlQueries($sql_queries);
    $switchmodel->setDatabaseConnectionSettings($database_connection_settings);
    $switchmodel->setDatabaseWrapper($database_wrapper);


    $switch['get'] = $switchmodel->getSwitches()['retrieved_switch'];

    return $switch;
}





