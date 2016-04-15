<?php namespace core\database;

class Db
{
    private static $instance = null;

    protected final static function getInstance()
    {
		if (is_null(self::$instance))
        {
            $driver = (defined('DB_DBDRIVER') ? DB_DBDRIVER : null);
            $dbHost = (defined('DB_HOSTNAME') ? DB_HOSTNAME : null);
            $dbPort = (defined('DB_CONNPORT') ? DB_CONNPORT : null);
            $dbName = (defined('DB_DATABASE') ? DB_DATABASE : null);
            $dbUser = (defined('DB_USERNAME') ? DB_USERNAME : null);
            $dbPass = (defined('DB_PASSWORD') ? DB_PASSWORD : null);

            if ($driver and $dbHost and $dbPort and $dbName and $dbUser) {
                self::$instance = new \PDO($driver . ':host=' . $dbHost . '; port=' . $dbPort . '; dbname=' . $dbName, $dbUser, $dbPass);
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            } else {
                throw new \Exception('You must define all parameters for connecting to database. See the configuration on app/config.php.');
            }
		}
	}

    protected final static function prepare($sql)
    {
        self::getInstance();
        if (!is_null(self::$instance)) {
            return self::$instance->prepare($sql);
        }
        return null;
	}

    protected final static function paramType($value = null)
    {
        switch (true) {
            case is_bool($value):
                $numberType = \PDO::PARAM_BOOL;
                break;
            case is_int($value):
                $numberType = \PDO::PARAM_INT;
                break;
            case is_string($value):
                $numberType = \PDO::PARAM_STR;
                break;
            default:
                $numberType = \PDO::PARAM_NULL;
                break;
        }
        return $numberType;
    }
}