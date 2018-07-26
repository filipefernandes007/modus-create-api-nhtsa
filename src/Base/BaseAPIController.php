<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     */

    namespace App\Base;

    /**
     * Class BaseAPIController
     * @package App\Base
     */
    abstract class BaseAPIController {
        const STATUS_CODE_OK         = 200;
        const STATUS_CODE_500        = 500;

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
    }