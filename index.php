<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
    $this->sendOutput(
        json_encode(array('error' => 'Action Not Found!')),
        array('Content-Type: application/json', 'HTTP/1.1 404 Not Found')
    );
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
$objFeedController = new UserController();
$arrQueryStringParams = $objFeedController->getQueryStringParams();

$strMethodName = $uri[3] . 'Action'; //create function name
$objFeedController->{$strMethodName}();
