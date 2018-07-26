<?php
    /**
     * Filipe <filipefernandes007@gmail.com>
     */

    namespace App\Model\Helper;


    use App\Model\VehicleModel;

    /**
     * Class VehicleModelHelper
     * @package App\Model\Helper
     */
    class VehicleModelHelper {
        const ID_ALIAS          = 'VehicleId';
        const DESCRIPTION_ALIAS = 'VehicleDescription';

        /**
         * @param null|object|array $value
         * @return VehicleModel|null
         */
        public static function makeModelOnResultRequest($value) {
            if (empty($value)) {
                return null;
            }

            $id = $description = null;

            if (\is_array($value)) {
                if (isset($value[self::DESCRIPTION_ALIAS])) {
                    $description = $value[self::DESCRIPTION_ALIAS];
                }

                if (isset($value[self::ID_ALIAS])) {
                    $id = $value[self::ID_ALIAS];
                }
            }

            if (\is_object($value)) {
                if (isset($value->{self::DESCRIPTION_ALIAS})) {
                    $description = $value->{self::DESCRIPTION_ALIAS};
                }

                if (isset($value->{self::ID_ALIAS})) {
                    $id = $value->{self::ID_ALIAS};
                }
            }

            if ($id !== null && $description !== null) {
                return new VehicleModel($id, $description);
            }

            return null;
        }
    }