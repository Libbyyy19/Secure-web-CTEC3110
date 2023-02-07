<?php


$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            "debug" => true
        ]
    );

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['messagesModel'] = function (){
    return new Telemetry\MessagesModel();

};

$container['soapwrapper'] = function (){
    return new Telemetry\soapwrapper();

};

$container['XmlParser'] = function () {
    return new Telemetry\XmlParser();

};

$container['validator'] = function () {
    return new Telemetry\Validator();

};

$container['DoctrineSqlQueries'] = function (){
    return new Telemetry\DoctrineSqlQueries();
};

$container['DatabaseWrapper'] = function ($container) {
    return new Telemetry\DatabaseWrapper();

};

$container['SQLQueries'] = function ($container) {
    return new Telemetry\SQLQueries();
};

$container['registerUser'] = function($container) {
    return new Telemetry\RegisterUser();
};

$container['registerUserView'] = function ($container) {
    return new Telemetry\RegisterUserView();
};

$container['registerModel'] = function ($container){
    return new Telemetry\RegisterModel();
};

$container['sessionWrapper'] = function ($container){
     return new Telemetry\SessionWrapper();
};

$container['sessionModel'] = function ($container){
    $session_model = new Telemetry\SessionModel();
    return $session_model;
};

$container['bcryptWrapper'] = function ($container){
    return new Telemetry\BcryptWrapper();
};

$container['processOutput'] = function ($container) {
    return new Telemetry\ProcessOutput();
};

$container['Messages'] = function ($container) {
    return new Telemetry\messagesModel();
};

$container['SwitchModel'] = function ($container){
    return new Telemetry\SwitchModel();
};

$container['downloadmessages'] = function ($container){
    return new Telemetry\downloadmessages();
};

$container['downloadmodel'] = function($container){
    return new Telemetry\downloadmessages();
};