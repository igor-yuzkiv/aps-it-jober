<?php


namespace App\Repository;


/**
 * Class RegistryRepository
 * @package App\Repository
 */
class RegistryRepository
{
    /**
     * @var array
     */
    private static $_storage = array(
        "client" => ClientRepository::class,
        "coefficient" => CoefficientRepository::class,
        "job_log" => JobLogRepository::class,
        "project" => ProjectRepository::class,
        "services_group" => ServicesGroupRepository::class,
        "services_item" => ServicesItemRepository::class,
        "units" => UnitsRepository::class,
        "users" => UsersRepository::class,
    );

    /**
     * @param $name
     * @return CoreRepository|null
     */
    public static function __callStatic($name, $arguments)
    {
        return self::get($name);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value)
    {
        return self::$_storage[$key] = $value;
    }

    /**
     * @param $key
     * @return CoreRepository|null
     */
    public static function get($key)
    {
        $result = null;
        if (isset(self::$_storage[$key])) {
            if (self::$_storage[$key] instanceof CoreRepository) {
                $result = self::$_storage[$key];
            } elseif (is_string(self::$_storage[$key]) && class_exists(self::$_storage[$key])) {
                $result = self::$_storage[$key] = new self::$_storage[$key];
            }
        }

        return $result;
    }


    /**
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        unset(self::$_storage[$key]);
        return true;
    }

    /**
     * @return bool
     */
    public static function clean()
    {
        self::$_storage = array();
        return true;
    }

}
