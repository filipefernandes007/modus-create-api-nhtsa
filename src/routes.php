<?php

    use Slim\Http\Request;
    use Slim\Http\Response;
    use App\model\CarModel;

    // requirement 1/3.
    $app->get('/vehicles/{modelYear:[0-9]+}/{manufacturer}/{model}', function (Request $request,
                                                                                      Response $response,
                                                                                      array $args) {
        /** @var null|string $withRating */
        $withRating = $request->getQueryParam('withRating');

        /** @var CarModel $carModel */
        $carModel = new CarModel($args);

        if (empty($withRating)) {
            $r = (new \App\Controller\VehiclesController())->model($carModel);
        } else {
            $r = (new \App\Controller\VehiclesController())->withRating($carModel);
        }

        $this->logger->info($request->getUri()->getPath() . ' : ' . $r);

        return $r;
    });

    // requirement 2.
    $app->post('/vehicles', function (Request $request, Response $response) {
        if (!in_array('application/json', $request->getHeader('Content-Type'))) {
            $r = $response->withJson(['error' => 'Only request content-type application json is accepted']);
        } else {
            $r = (new \App\Controller\VehiclesController())->model(new CarModel($this->request->getParsedBody()));
        }

        $this->logger->info($request->getUri()->getPath() . ' : ' . $r);

        return $r;
    });

    $app->get('/async', function (Request $request, Response $response) use($app) {
        echo $app->subRequest('GET', '/vehicles/2015/Toyota/Yaris')->getBody();
    });