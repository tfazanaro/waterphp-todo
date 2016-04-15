<?php namespace core\utils;

final class Session
{
    use \core\traits\ClassMethods;

    private static function timeout()
    {
        if (self::get('app_session_time') && (time() > self::get('app_session_time'))) {
            self::stop();
            return true;
        } else {
            self::set('app_session_time', time() + SESSION_LIFETIME, true);
            self::set('app_session_token', Encryption::encode(md5(uniqid(rand(), true))));
            self::set('app_session_encryption_key', ENCRYPTION_KEY);
            self::set('app_session_language', DEFAULT_LANGUAGE);
            return false;
        }
    }

    public static function start()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        session_start();
        return !self::timeout();
    }

    public static function stop()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        if (session_id()) {
            session_unset();
            session_destroy();
            return true;
        }
        return false;
    }

    public static function set($key, $value, $force = false)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 2, 3);
        self::validateArgType(__FUNCTION__, $key, 1, ['string']);
        self::validateArgType(__FUNCTION__, $force, 3, ['bool']);

        if (is_string($key) and (!isset($_SESSION[$key]) or $force)) {
            $_SESSION[$key] = $value;
        }
    }

    public static function get($key)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $key, 1, ['string']);

        if (is_string($key) and isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public static function forget($key)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $key, 1, ['string']);

        if (is_string($key) and substr($key, 0, 12) !== 'app_session_') {
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
                return true;
            }
        }
        return false;
    }

    public static function token()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        if (self::get('app_session_token')) {
            return Encryption::decode(self::get('app_session_token'));
        }
        return '';
    }
}
