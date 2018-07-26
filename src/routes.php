<?php

    use Slim\Http\Request;
    use Slim\Http\Response;

    // requirement 1/3.
    $app->get('/vehicles/{modelYear:[0-9]+}/{manufacturer}/{model}', \App\Controller\VehiclesController::class . ':getVehicles');

    // requirement 2.
    $app->post('/vehicles', \App\Controller\VehiclesController::class . ':postVehicles');

    $app->get('/async', function (Request $request, Response $response) use($app) {
        echo $app->subRequest('GET', '/vehicles/2015/Toyota/Yaris')->getBody();
    });