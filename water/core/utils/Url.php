<?php namespace core\utils;

use core\routing\Get;
use core\routing\Router;

final class Url
{
    use \core\traits\ClassMethods;

    public static function current()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        if (Get::urlSegments()) {
            $url = self::base() . '/' . Get::urlSegments();
        } else {
            $url = self::base();
        }
        return $url;
    }

    public static function base($segments = null, $params = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 0, 2);
        self::validateArgType(__FUNCTION__, $segments, 1, ['string', 'null']);
        self::validateArgType(__FUNCTION__, $params, 2, ['array', 'null']);

        if ($segments and is_string($segments) and strlen($segments) > 0) {
            if ($params and is_array($params) and count($params) > 0) {
                $params = implode('/', $params);
                return BASE_URL . '/' . $segments . '/' . $params;
            }
            return BASE_URL . '/' . $segments;
        }
        return BASE_URL;
    }

    public static function route($routeName, $params = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 2);
        self::validateArgType(__FUNCTION__, $routeName, 1, ['string']);
        self::validateArgType(__FUNCTION__, $params, 2, ['array', 'null']);

        if (is_string($routeName) and strlen($routeName) > 0) {

            $routes = Router::getRoutes();
            $route = (array_key_exists($routeName, $routes)) ? $routeName : null;

            return ($route) ? self::base($route, $params) : '';
        }
        return '';
    }

    public static function controller($controllerName, $params = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 2);
        self::validateArgType(__FUNCTION__, $controllerName, 1, ['string']);
        self::validateArgType(__FUNCTION__, $params, 2, ['array', 'null']);

        if (is_string($controllerName) and strlen($controllerName) > 0) {

            $routes = Router::getRoutes();
            $route = array_search($controllerName, $routes);

            return ($route) ? self::base($route, $params) : '';
        }
        return '';
    }

    public static function asset($resource)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $resource, 1, ['string']);

        if (is_string($resource) and strlen($resource) > 0) {
            return PUBLIC_URL . '/' . $resource;
        }
        return '';
    }
}
