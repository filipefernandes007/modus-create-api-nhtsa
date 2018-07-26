<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     * 26/07/2018 04:27
     */

    namespace App\model;

    /**
     * Class CarModel
     * @package App\model
     */
    class CarModel {
        /** @var int */
        protected $modelYear;

        /** @var string */
        protected $manufacturer;

        /** @var string */
        protected $model;

        /**
         * CarModel constructor.
         * @param array $args
         */
        public function __construct(array $args) {
            if (\count($args) < 3) {
                throw new \LengthException('Expecting an array with length 3, got ' . \count($args));
            }

            if (isset($args['modelYear'])) {
                $this->modelYear = $args['modelYear'];
            }

            if (isset($args['manufacturer'])) {
                $this->manufacturer = $args['manufacturer'];
            }

            if (isset($args['model'])) {
                $this->model = $args['model'];
            }
        }

        /**
         * @return int
         */
        public function getModelYear() : int {
            return $this->modelYear;
        }

        /**
         * @param int $modelYear
         * @return CarModel
         */
        public function setModelYear(int $modelYear) : CarModel {
            $this->modelYear = $modelYear;

            return $this;
        }

        /**
         * @return string
         */
        public function getManufacturer() : string {
            return $this->manufacturer;
        }

        /**
         * @param string $manufacturer
         * @return CarModel
         */
        public function setManufacturer(string $manufacturer) : CarModel {
            $this->manufacturer = $manufacturer;

            return $this;
        }

        /**
         * @return string
         */
        public function getModel() : string {
            return $this->model;
        }

        /**
         * @param string $model
         * @return CarModel
         */
        public function setModel(string $model) : CarModel {
            $this->model = $model;

            return $this;
        }

    }