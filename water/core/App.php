<?php namespace core;

use core\base\View;
use core\routing\Get;
use core\routing\Router;
use core\utils\Redirect;
use core\utils\Request;
use core\utils\Session;
use core\utils\Url;

final class App {

    public function __construct()
    {
        if (!Session::start()) {
            Redirect::to(Url::base());
        } else {
            $this->load();
        }
    }

    private function load()
    {
        $this->verifyCSRFToken();

        if (!Get::urlController())
        {
            if (CONTROLLER_INDEX) {
                if (file_exists(CONTROLLER_PATH . CONTROLLER_INDEX . '.php')) {
                    $controller = 'controller\\' . CONTROLLER_INDEX;
                    $controller = new $controller();
                    $controller->index();
                } else {
                    View::load(ERROR_404_VIEW);
                }
            } else {
                View::load(ERROR_404_VIEW);
            }
        } else {

            $router = new Router();

            $controller = $router->getController();
            $method = $router->getMethod();
            $params = $router->getParams();

            $controller = ($controller) ? $controller : Get::urlController();
            $method = ($method) ? $method : Get::urlMethod();
            $params = ($params) ? $params : Get::urlParams();

            $namespace = 'controller\\';
            $continue = file_exists(CONTROLLER_PATH . $controller . '.php');

            if ($controller === 'debug') {
                $namespace = 'core\\error\\';
                $controller = ucfirst($controller);
                $continue = file_exists(LIB_PATH . 'core' . DS . 'error' . DS . $controller . '.php');
            }

            if ($continue)
            {
                $controller = $namespace . str_replace(DS, '\\', $controller);
                $controller = new $controller();

                if (method_exists($controller, $method))
                {
                    if (is_array($params) and count($params) > 0) {
                        call_user_func_array(array($controller, $method), $params);
                    } else {
                        $controller->{$method}();
                    }
                } else {
                    if (strlen($method) == 0) {
                        $controller->index();
                    } else {
                        View::load(ERROR_404_VIEW);
                    }
                }
            } else {
                View::load(ERROR_404_VIEW);
            }
        }
    }

    private function verifyCSRFToken()
    {
        if ($this->verifyEncryptionKey()) {
            $token = Request::get('_token');
            if ($token) {
                if (Session::token() != trim($token)) {
                    trigger_error('The given token is not a valid token! See <b>CSRF</b> protection in the documentation for more details.', E_USER_ERROR);
                }
            }
        }
    }

    private function verifyEncryptionKey()
    {
        if (ENCRYPTION_KEY) {
            if (Session::get('app_session_encryption_key') != ENCRYPTION_KEY) {
                Session::stop();
                if (DEBUG_MODE) {
                    trigger_error('The encryption key has been changed! The application will be restart.', E_USER_NOTICE);
                } else {
                    Redirect::to(Url::base());
                }
            }
        } else {
            trigger_error('The encryption key is not defined! See the application configuration file (config.php).', E_USER_ERROR);
        }
        return true;
    }
}
