<?php

/*
 * ========================================
 * URL HELPERS
 * ========================================
 */

if (!function_exists('current'))
{
    /*
     * @deprecated deprecated since version 1.3.0
     */
    function current()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Url::current();
    }
}

if (!function_exists('current_url'))
{
    function current_url()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Url::current();
    }
}

if (!function_exists('base'))
{
    /*
     * @deprecated deprecated since version 1.3.0
     */
    function base()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Url::base();
    }
}

if (!function_exists('base_url'))
{
    function base_url()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Url::base();
    }
}

if (!function_exists('url'))
{
    function url($str, $params = null)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 2);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $str, 1, ['string']);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $params, 2, ['array', 'null']);

        return core\utils\Url::base($str, $params);
    }
}

if (!function_exists('controller'))
{
    function controller($controllerName, $params = null)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 2);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $controllerName, 1, ['string']);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $params, 2, ['array', 'null']);

        return core\utils\Url::controller($controllerName, $params);
    }
}

if (!function_exists('route'))
{
    function route($routeName, $params = null)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 2);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $routeName, 1, ['string']);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $params, 2, ['array', 'null']);

        return core\utils\Url::route($routeName, $params);
    }
}

if (!function_exists('asset'))
{
    function asset($resource)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $resource, 1, ['string']);

        return core\utils\Url::asset($resource);
    }
}

/*
 * ========================================
 * PATH HELPERS
 * ========================================
 */

if (!function_exists('public_path'))
{
    function public_path()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return (defined('PUBLIC_PATH') ? PUBLIC_PATH : '');
    }
}

if (!function_exists('image_path'))
{
    function image_path()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return (defined('IMAGE_PATH') ? IMAGE_PATH : '');
    }
}

/*
 * ========================================
 * LANGUAGE HELPERS
 * ========================================
 */

if (!function_exists('default_language'))
{
    function default_language()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return (defined('DEFAULT_LANGUAGE') ? DEFAULT_LANGUAGE : '');
    }
}

if (!function_exists('session_language'))
{
    function session_language()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Lang::getSessionLanguage();
    }
}

/*
 * ========================================
 * MISCELLANEOUS
 * ========================================
 */

if (!function_exists('view'))
{
    /*
     * @deprecated deprecated since version 1.3.0
     */
    function view($view)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $view, 1, ['string']);

        core\base\View::load($view);
    }
}

if (!function_exists('load'))
{
    function load($view)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $view, 1, ['string']);

        core\base\View::load($view);
    }
}

if (!function_exists('strings'))
{
    function strings()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Lang::strings();
    }
}

if (!function_exists('auth'))
{
    function auth()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return (core\utils\Auth::user()) ? new core\utils\Auth() : null;
    }
}

if (!function_exists('token'))
{
    /*
     * @deprecated deprecated since version 1.3.0
     */
    function token()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Session::token();
    }
}

if (!function_exists('session_token'))
{
    function session_token()
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args());

        return core\utils\Session::token();
    }
}

if (!function_exists('old'))
{
    /*
     * @deprecated deprecated since version 1.3.0
     */
    function old($name)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $name, 1, ['string']);

        return core\utils\Request::get($name);
    }
}

if (!function_exists('previous'))
{
    function previous($name)
    {
        core\traits\ClassMethods::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        core\traits\ClassMethods::validateArgType(__FUNCTION__, $name, 1, ['string']);

        return core\utils\Request::get($name);
    }
}
