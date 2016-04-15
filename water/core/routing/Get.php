<?php namespace core\routing;

final class Get
{
    private static function splitUrl($type = null)
    {
        if (self::urlSegments())
        {
            $segments = array();

            $url = explode('/', self::urlSegments());

            $segments['controller'] = $controller = isset($url[0]) ? $url[0] : null;
            $segments['method'] = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $segments['params'] = array_values($url);

            if ($type) {
                return $segments[$type];
            } else {
                return $segments;
            }
        }
        return null;
    }

    public static function urlSegments()
    {
        $url = null;
        if (isset($_GET['url']))
        {
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        return $url;
    }

    public static function urlController()
    {
        return self::splitUrl('controller');
    }

    public static function urlMethod()
    {
        return self::splitUrl('method');
    }

    public static function urlParams()
    {
        return self::splitUrl('params');
    }
}