<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     * 25/07/2018 22:36
     */

    namespace App\Controller;


    use App\Base\BaseAPIController;
    use App\model\CarModel;
    use App\Model\Helper\CarModelHelper;
    use App\Model\Helper\VehicleModelHelper;
    use App\model\ResultOnResponseModel;
    use GuzzleHttp;
    use Slim\Http\Request;
    use Slim\Http\Response;

    /**
     * Class Vehicles
     * @package App\Controller
     */
    class VehiclesController extends BaseAPIController {
        const API_REQUEST_BASE_URL   = 'https://one.nhtsa.gov/webapi/api/SafetyRatings';

        /**
         * @param Request  $request
         * @param Response $response
         * @param array    $args
         * @return Response
         */
        public function getVehicles(Request $request, Response $response, array $args) : Response {
            /** @var null|string $withRating */
            $withRating = $request->getQueryParam('withRating');

            /** @var CarModel $carModel */
            $carModel = CarModelHelper::makeModelOnResultRequest($args);

            if (!empty($withRating) && $withRating === 'true') {
                $r = $this->withRating($carModel);
            } else {
                $r = $this->model($carModel);
            }

            $this->logger->info($request->getUri()->getPath() . ' : ' . $r);

            return $r;
        }

        /**
         * @param Request  $request
         * @param Response $response
         * @return Response
         */
        public function postVehicles(Request $request, Response $response) : Response {
            if (!\in_array('application/json', $request->getHeader('Content-Type'))) {
                $r = $response->withJson(['error' => 'Only request content-type application json is accepted']);
            } else {
                /** @var CarModel $carModel */
                $carModel = CarModelHelper::makeModelOnResultRequest($request->getParsedBody());

                $r = $this->model($carModel);
            }

            $this->logger->info($request->getUri()->getPath() . ' : ' . $r);

            return $r;
        }

        /**
         * Method to get model.
         *
         * @param CarModel $carModel
         * @return Response
         */
        protected function model(CarModel $carModel) : Response {
            $guzzleClient = new GuzzleHttp\Client();

            try {
                /** @var \GuzzleHttp\Psr7\Response $guzzleResponse */
                $guzzleResponse = $guzzleClient->request('GET', $this->makeUrlModelRequest($carModel));

                /** @var ResultOnResponseModel $resultObjectOnResponse */
                $resultObjectOnResponse = new ResultOnResponseModel(json_decode($guzzleResponse->getBody()->getContents()));
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                // send what can be considered an empty result : Count = 0 ; Results = []
                $resultObjectOnResponse = new ResultOnResponseModel();

                $this->logger->error($this->makeUrlModelRequest($carModel) . ' : ' . $e->getMessage());
            }

            return (new Response())->withStatus(self::STATUS_CODE_OK)
                                   ->withHeader('Content-Type', 'application/json; charset=utf-8')
                                   ->withJson($resultObjectOnResponse->asArray(), self::STATUS_CODE_OK);
        }

        /**
         * @param CarModel $carModel
         * @return Response
         */
        public function withRating(CarModel $carModel) : Response {
            /** @var \Slim\Http\Response $result */
            $result = $this->model($carModel);

            /** @var string[] $finalResults */
            $finalResults = [];

            if ($result->getStatusCode() === self::STATUS_CODE_OK) {
                $guzzleClient = new GuzzleHttp\Client();

                /** @var ResultOnResponseModel $resultObjectOnResponse */
                $resultObjectOnResponse = new ResultOnResponseModel(json_decode($result->getBody()));

                foreach ($resultObjectOnResponse->getResults() as $value) {
                    $vehicle = VehicleModelHelper::makeModelOnResultRequest($value);

                    if ($vehicle !== null) {
                        try {
                            /** @var \GuzzleHttp\Psr7\Response $guzzleResponse */
                            $guzzleResponse = $guzzleClient->request('GET', $this->makeUrlVehicleRequest($vehicle->getId()));

                            /** @var ResultOnResponseModel $resultObjectOnResponse */
                            $resultObjectOnResponse = new ResultOnResponseModel(json_decode($guzzleResponse->getBody()->getContents()));

                            if (!empty($resultObjectOnResponse) && $resultObjectOnResponse->getCount() > 0) {
                                $carModel = CarModelHelper::makeModelOnResultRequest($resultObjectOnResponse->getResults()[0]);

                                $finalResults[] = ['CrashRating' => $carModel->getOverallRating(),
                                                   'Description' => $vehicle->getDescription(),
                                                   'VehicleId'   => $vehicle->getId()];
                            }
                        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                            return (new Response())->withStatus($guzzleResponse->getStatusCode())
                                                   ->withHeader('Content-Type', 'application/json; charset=utf-8')
                                                   ->withJson(['error' => 'Server error', 'statusCode' => $guzzleResponse->getStatusCode()], $guzzleResponse->getStatusCode());
                        }
                    }
                }
            }

            if (!isset($resultObjectOnResponse)) {
                return (new Response())->withStatus(self::STATUS_CODE_500)
                                       ->withHeader('Content-Type', 'application/json; charset=utf-8')
                                       ->withJson(['error' => 'Server error!', 'statusCode' => self::STATUS_CODE_500], self::STATUS_CODE_500);
            }

            $resultObjectOnResponse->setCount(\count($finalResults));
            $resultObjectOnResponse->setResults($finalResults);

            return (new Response())->withStatus(self::STATUS_CODE_OK)
                                   ->withHeader('Content-Type', 'application/json; charset=utf-8')
                                   ->withJson($resultObjectOnResponse->asArray(), self::STATUS_CODE_OK);
        }

        /**
         * @param CarModel $carModel
         * @return string
         */
        private function makeUrlModelRequest(CarModel $carModel) : string {
            return self::API_REQUEST_BASE_URL . "/modelyear/{$carModel->getModelYear()}/make/{$carModel->getManufacturer()}/model/{$carModel->getModel()}?format=json";
        }

        /**
         * @param int $id
         * @return string
         */
        private function makeUrlVehicleRequest(int $id) : string {
            return self::API_REQUEST_BASE_URL . "/VehicleId/{$id}?format=json";
        }
    }