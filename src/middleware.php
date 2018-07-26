<?php
// Application middleware

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, \Slim\Http\Response $response) {
        return $response->withJson(['error' => 'Invalid end-point: missing values or malformed url. Please check, and submit again.', 'statusCode' => 404], 404);
    };
};

$container['errorHandler'] = function (\Slim\Container $c) {
    return function (\Slim\Http\Request $request, \Slim\Http\Response $response, $exception) use ($c) {
        /** @var \Monolog\Logger $logger */
        $logger = $c->get('logger');

        $logger->error($request->getUri()->getPath() . ' : ' . $exception->getMessage());
        return $response->withJson(['error' => 'Something went wrong.', 'statusCode' => \App\Base\BaseAPIController::STATUS_CODE_500], \App\Base\BaseAPIController::STATUS_CODE_500);
    };
};

