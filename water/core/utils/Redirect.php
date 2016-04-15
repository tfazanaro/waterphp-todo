<?php namespace core\utils;

final class Redirect
{
    use \core\traits\ClassMethods;

    public static function to($url)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $url, 1, ['string']);

        if (!headers_sent()) {
            session_write_close();
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $url);
            exit();
        }
    }
}