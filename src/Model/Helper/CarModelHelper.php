<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     */

    namespace App\Model\Helper;


    use App\model\CarModel;

    /**
     * Class CarModelHelper
     * @package App\Model\Helper
     */
    class CarModelHelper {
        /**
         * @param $args
         * @return CarModel
         */
        public static function makeModelOnResultRequest($args) {
            if (\is_object($args)) {
                $args = (array) $args;
            }

            if (\is_array($args) && \count($args) < 3) {
                throw new \LengthException('Expecting an array with length 3, got ' . \count($args));
            }

            $model = new CarModel();

            foreach ($args as $key => $value) {
                $method = 'set' . ucfirst($key);

                if (method_exists(CarModel::class, $method)) {
                    \call_user_func_array(array($model, $method), array($value));
                }
            }

            return $model;
        }
    }