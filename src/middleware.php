<?php
// Application middleware

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, \Slim\Http\Response $response) {
        return $response->withJson(['error' => 'Invalid end-point: missing values or malformed url. Please check, and submit again.', 'statusCode' => 404], 404);
    };
};


