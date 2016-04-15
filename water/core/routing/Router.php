<?php namespace core\routing;

final class Router {

    private static $routes = [];
    private $controller = null;
    private $method = null;

    use \core\traits\ClassMethods;

    private static function checkRouteName($routeName)
    {
        $pattern = '/^([a-z]+[0-9]*[_|.|-]{0,1})+$/';
        $result = preg_match($pattern, $routeName);
        if ($result) {
            return true;
        } else {
            $_SESSION['debug_backtrace_file'] = debug_backtrace()[1]['file'];
            $_SESSION['debug_backtrace_line'] = debug_backtrace()[1]['line'];
            trigger_error('The route name "<b>'.$routeName.'</b>" is not a valid name. You must use letters, if you want numbers and "_" (underscore), "-" (dash) and "." (dot) to separate words.', E_USER_ERROR);
        }
    }

    private function isControllerMethod($controllerMethod)
    {
        $segments = explode('@', $controllerMethod);
        if (is_array($segments) and count($segments) === 2) {
            return $segments;
        }
        return false;
    }

    private function setControllerMethod($controllerMethod)
    {
        $segments = $this->isControllerMethod($controllerMethod);
        if ($segments) {
            $this->controller = $this->getOSPath($segments[0]);
            $this->method = $segments[1];
        } else {
            $this->controller = $this->getOSPath(self::$routes[Get::urlController()]);
            $this->method = null;
        }
    }

    private function getOSPath($controller)
    {
        $controller = str_replace('/', DS, $controller);
        return $controller;
    }

    public static function getRoutes()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        return self::$routes;
    }

    public function getController()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        $routeName = Get::urlController();
        if (isset(self::$routes[$routeName])) {
            $this->setControllerMethod(self::$routes[$routeName]);
        } else {
            $routeName = Get::urlSegments();
            if (isset(self::$routes[$routeName])) {
                $this->setControllerMethod(self::$routes[$routeName]);
            } else {
                return null;
            }
        }
        return $this->controller;
    }

    public function getMethod()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        if ($this->getController()) {
            return $this->method;
        }
        return null;
    }

    public function getParams()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        if ($this->getMethod())
        {
            $routeName = array_search($this->controller . '@' . $this->method, self::$routes);
            $segments = str_replace($routeName, '', Get::urlSegments());
            if (substr($segments, 0, 1) == '/') {
                $segments = substr($segments, 1, strlen($segments)-1);
            }
            $params = explode('/', $segments);
            $params = array_values($params);
            return $params;
        }
        return null;
    }

    public function controller($routeName, $controller)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 2, 2);
        self::validateArgType(__FUNCTION__, $routeName, 1, ['string']);
        self::validateArgType(__FUNCTION__, $controller, 2, ['string']);

        if ($this->checkRouteName($routeName))
        {
            if (!$this->isControllerMethod($controller))
            {
                if (!isset(self::$routes[$routeName]))
                {
                    self::$routes[$routeName] = $controller;
                }
            }
        }
    }

    public function controllerMethod($routeName, $controllerMethod)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 2, 2);
        self::validateArgType(__FUNCTION__, $routeName, 1, ['string']);
        self::validateArgType(__FUNCTION__, $controllerMethod, 2, ['string']);

        if ($this->checkRouteName($routeName))
        {
            if ($this->isControllerMethod($controllerMethod))
            {
                if (!isset(self::$routes[$routeName]))
                {
                    self::$routes[$routeName] = $controllerMethod;
                }
            }
        }
    }
}
