<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     * 26/07/2018 01:32
     *
     * Run: composer test || ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/Unit/GetModelsTest
     */

    namespace Tests\Unit;

    use PHPUnit\Framework\TestCase;
    use Tests\Functional\BaseTestCase;

    /**
     * Class GetModels
     * @package Tests\Unit
     */
    final class GetModelsTest extends BaseTestCase {


        /**
         * @throws \Slim\Exception\MethodNotAllowedException
         * @throws \Slim\Exception\NotFoundException
         */
        public function testRequirement11() {
            $response = $this->runApp('GET', '/vehicles/2015/Audi/A3');
            $this->assertEquals(200, $response->getStatusCode());
        }

        public function testRequirement12() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', 'http://localhost:8080/vehicles/2015/Toyota/Yaris');
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(2, $result->Count);

            });

            $promise->wait();
        }

        public function testRequirement13() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', 'http://localhost:8080/vehicles/2015/Ford/Crown Victoria');
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(0, $result->Count);

            });

            $promise->wait();
        }

        /**
         * @throws \Slim\Exception\MethodNotAllowedException
         * @throws \Slim\Exception\NotFoundException
         */
        public function testRequirement14() {
            $response = $this->runApp('GET', '/vehicles/undefined/Ford/Fusion');
            $this->assertEquals(404, $response->getStatusCode());
        }

        public function testRequirement21() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('POST',
                                                    'http://localhost:8080/vehicles',
                                                     ['Content-Type' => 'application/json'],
                                                     json_encode(['modelYear'    => 2015,
                                                                  'manufacturer' => 'Audi',
                                                                  'model'        => 'A3']));
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(4, $result->Count);

            });

            $promise->wait();
        }

        public function testRequirement22() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('POST',
                                                        'http://localhost:8080/vehicles',
                                                            ['Content-Type' => 'application/json'],
                                                            json_encode(['modelYear'    => 2015,
                                                                         'manufacturer' => 'Toyota',
                                                                         'model'        => 'Yaris']));
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(2, $result->Count);

            });

            $promise->wait();
        }

        public function testRequirement31() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', 'http://localhost:8080/vehicles/2015/Audi/A3?withRating=true');
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(4, $result->Count);

            });

            $promise->wait();
        }

        public function testRequirement32() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', 'http://localhost:8080/vehicles/2015/Audi/A3?withRating=bananas');
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(4, $result->Count);

            });

            $promise->wait();
        }

        public function testRequirement33() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', 'http://localhost:8080/vehicles/2015/Audi/A3?withRating=false');
            $promise = $client->sendAsync($request)->then(function (\GuzzleHttp\Psr7\Response $response) {
                $result = json_decode($response->getBody()->getContents());

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals(4, $result->Count);

            });

            $promise->wait();
        }

        /**
         * @throws \GuzzleHttp\Exception\GuzzleException
         */
        public function testFail1() {
            $client  = new \GuzzleHttp\Client();
            $request = new \GuzzleHttp\Psr7\Request('POST',
                                                    'http://localhost:8080/vehicles',
                                                    ['Content-Type' => 'application/json'],
                                                    json_encode(['manufacturer' => 'Honda',
                                                                 'model'        => 'Accord']));
            try {
                $client->send($request);
            } catch (\GuzzleHttp\Exception\ServerException $e) {
                $errorObj = json_decode($e->getResponse()->getBody()->getContents());

                $this->assertEquals('0', $errorObj->Count);
                $this->assertEquals(0, count($errorObj->Results));
            }

        }
    }