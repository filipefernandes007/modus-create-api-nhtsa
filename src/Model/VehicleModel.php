<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     */

    namespace App\Model;

    /**
     * Class VehicleModel
     * @package App\Model
     */
    class VehicleModel {
        /** @var int */
        protected $id;

        /** @var string */
        protected $description;

        /**
         * VehicleModel constructor.
         * @param int    $id
         * @param string $description
         */
        public function __construct(int $id, string $description) {
            $this->id          = $id;
            $this->description = $description;
        }

        /**
         * @return int
         */
        public function getId() : int {
            return $this->id;
        }

        /**
         * @param int $id
         * @return VehicleModel
         */
        public function setId(int $id) : VehicleModel {
            $this->id = $id;

            return $this;
        }

        /**
         * @return string
         */
        public function getDescription() : string {
            return $this->description;
        }

        /**
         * @param string $description
         * @return VehicleModel
         */
        public function setDescription(string $description) : VehicleModel {
            $this->description = $description;

            return $this;
        }

    }