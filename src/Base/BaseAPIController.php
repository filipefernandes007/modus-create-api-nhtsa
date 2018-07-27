<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     */

    namespace App\Base;
    use Slim\Http\Request;
    use Slim\Http\Response;

    /**
     * Class BaseAPIController
     * @package App\Base
     */
    class BaseAPIController {
        const STATUS_CODE_OK           = 200;
        const STATUS_CODE_NOT_FOUND    = 404;
        const STATUS_CODE_SERVER_ERROR = 500;

        /** @var \Slim\Container */
        protected $container;

        /** @var \Slim\App */
        protected $app;

        /** @var \Monolog\Logger  */
        protected $logger;

        /**
         * BaseAPIController constructor.
         * @param \Slim\Container $container
         * @throws \Interop\Container\Exception\ContainerException
         */
        public function __construct(\Slim\Container $container) {
            $this->container = $container;
            $this->app       = $container->get('app');
            $this->logger    = $container->get('logger');
        }

        /**
         * @param Request $request
         * @return array
         */
        protected function getRequestData(Request $request) : array {
            return ['method' => $request->getMethod(), 'postData' => $request->getParsedBody(), 'queryString' => $request->getQueryParams()];
        }

        /**
         * @param Response $response
         * @return array
         */
        protected function getResponseData(Response $response) : array {
            return ['result' => $response->getBody()->getContents()];
        }

        /**
         * @param Request  $request
         * @param Response $response
         * @param array    $result
         * @return array
         */
        protected function mergeRequestResponseData(Request $request, Response $response, array $result = []) : array {
            return [];
            return ['request'  => $this->getRequestData($request),
                    'response' => $this->getResponseData($response),
                    'result'   => $result];
        }
    }