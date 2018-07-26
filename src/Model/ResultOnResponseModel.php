<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     * 25/07/2018 23:29
     */

    namespace App\model;

    /**
     * Class ResultOnResponseModel
     * @package App\model
     */
    class ResultOnResponseModel {
        /** @var int */
        protected $count = 0;

        /** @var array */
        protected $results = [];

        /**
         * ResultOnResponse constructor.
         * @param null|string|\stdClass $result
         */
        public function __construct($result = null) {
            if ($result !== null) {
                if (\is_string($result)) {
                    $result = json_decode($result);
                }

                $this->count   = $result->Count;
                $this->results = $result->Results;
            }
        }

        /**
         * @return int
         */
        public function getCount() : int {
            return $this->count;
        }

        /**
         * @param int $count
         * @return ResultOnResponseModel
         */
        public function setCount(int $count) : ResultOnResponseModel {
            $this->count = $count;

            return $this;
        }

        /**
         * @return array|null
         */
        public function getResults() : array {
            return $this->results;
        }

        /**
         * @param array|null $results
         * @return ResultOnResponseModel
         */
        public function setResults(array $results) : ResultOnResponseModel {
            $this->results = $results;

            return $this;
        }

        /**
         * @return array
         */
        public function asArray() : array {
            return ['Count'   => $this->count,
                    'Results' => $this->results];
        }

    }