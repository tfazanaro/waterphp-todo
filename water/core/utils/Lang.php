<?php namespace core\utils;

final class Lang
{
    private static $xml = null;
    private static $loaded = 0;

    use \core\traits\ClassMethods;

    public static function setSessionLanguage($language)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $language, 1, ['string']);

        $language = is_string($language) ? $language : DEFAULT_LANGUAGE;

        Session::set('app_session_language', $language, true);

        self::load(self::getSessionLanguage());
    }

    public static function getSessionLanguage()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        return Session::get('app_session_language');
    }

    public static function load($language = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 0, 1);
        self::validateArgType(__FUNCTION__, $language, 1, ['string', 'null']);

        $reload = 0;

        if ($language and is_string($language)) {
            $reload = 1;
        } else {
            $language = self::getSessionLanguage();
        }

        $file = LANGUAGE_PATH . $language . DS . 'strings.xml';

        if ((!self::$loaded and file_exists($file)) or $reload) {
            self::$xml = simplexml_load_file($file);
            self::$loaded = 1;
            return true;
        }
        return false;
    }

    public static function strings($node = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 0, 1);
        self::validateArgType(__FUNCTION__, $node, 1, ['string', 'null']);

        self::load();

        if ($node and is_string($node)) {
            $strings = (isset(self::$xml->{$node})) ? self::$xml->{$node} : null;
        } else {
            $strings = self::$xml;
        }
        return $strings;
    }
}
