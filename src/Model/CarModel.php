<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
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

        /** @var string */
        protected $overallRating;

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
        public function getMake() : string {
            return $this->manufacturer;
        }

        /**
         * @param string $manufacturer
         * @return CarModel
         */
        public function setMake(string $manufacturer) : CarModel {
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

        /**
         * @return string
         */
        public function getOverallRating() : string {
            return $this->overallRating;
        }

        /**
         * @param string $overallRating
         * @return CarModel
         */
        public function setOverallRating(string $overallRating) : CarModel {
            $this->overallRating = $overallRating;

            return $this;
        }



    }