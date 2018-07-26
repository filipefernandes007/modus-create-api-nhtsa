<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     * 25/07/2018 22:36
     */

    namespace App\Controller;


    use App\model\CarModel;
    use App\model\ResultOnResponseModel;
    use GuzzleHttp;
    use Slim\Http\Response;

    /**
     * Class Vehicles
     * @package App\Controller
     */
    class VehiclesController extends Response {
        const API_REQUEST_URL = 'https://one.nhtsa.gov/webapi/api/SafetyRatings';

        /**
         * Action to get model.
         *
         * @param CarModel $carModel
         * @return Response
         */
        public function model(CarModel $carModel) : Response {
            $guzzleClient = new GuzzleHttp\Client();

            try {
                /** @var \GuzzleHttp\Psr7\Response $guzzleResponse */
                $guzzleResponse = $guzzleClient->request('GET', $this->makeUrlModelRequest($carModel));

                /** @var ResultOnResponseModel $resultObjectOnResponse */
                $resultObjectOnResponse = new ResultOnResponseModel(json_decode($guzzleResponse->getBody()->getContents()));
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                // send what can be considered an empty result : Count = 0 ; Results = []
                $resultObjectOnResponse = new ResultOnResponseModel();
            }

            return $this->withStatus(200)
                        ->withHeader('Content-Type', 'application/json; charset=utf-8')
                        ->withJson($resultObjectOnResponse->asArray(), 200);
        }

        public function withRating(CarModel $carModel) {
            return 'withRating';
        }

        /**
         * @param CarModel $carModel
         * @return string
         */
        private function makeUrlModelRequest(CarModel $carModel) : string {
            return self::API_REQUEST_URL . "/modelyear/{$carModel->getModelYear()}/make/{$carModel->getManufacturer()}/model/{$carModel->getModel()}?format=json";
        }
    }