<?php

// Application middleware

//Override the default Not Found Handler
$container['notFoundHandler'] = function (\Slim\Container $c) {
    return function (\Slim\Http\Request $request, \Slim\Http\Response $response) use($c) {
        /** @var \Monolog\Logger $logger */
        $logger = $c->get('logger');

        $errorOutput = ['Count' => '0', 'Results' => [], 'error' => 'Invalid end-point: missing values or malformed url. Please check, and submit again.', 'statusCode' => \App\Base\BaseAPIController::STATUS_CODE_NOT_FOUND];

        \App\Helper\LoggerResultHelper::instance($logger)->result(\App\Helper\LoggerResultHelper::ERROR_TYPE, $request, $response, json_encode($errorOutput));

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8')->withJson($errorOutput, \App\Base\BaseAPIController::STATUS_CODE_NOT_FOUND);
    };
};

$container['errorHandler'] = function (\Slim\Container $c) {
    return function (\Slim\Http\Request $request, \Slim\Http\Response $response, $exception) use ($c) {
        /** @var \Monolog\Logger $logger */
        $logger = $c->get('logger');

        $errorOutput = ['Count' => '0', 'Results' => [], 'error' => $exception->getMessage(), 'statusCode' => \App\Base\BaseAPIController::STATUS_CODE_SERVER_ERROR] ;

        \App\Helper\LoggerResultHelper::instance($logger)->result(\App\Helper\LoggerResultHelper::ERROR_TYPE, $request, $response, json_encode($errorOutput));

        return $response->withJson(['Count' => '0', 'Results' => [], 'error' => $exception->getMessage(), 'statusCode' => \App\Base\BaseAPIController::STATUS_CODE_SERVER_ERROR], \App\Base\BaseAPIController::STATUS_CODE_SERVER_ERROR);
    };
};


