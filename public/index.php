<?php

ini_set('error_reporting', E_ALL);
ini_set('display_error', 0);

/*
 * ==============================================================
 * PATHS
 * ==============================================================
 */

define('DS', DIRECTORY_SEPARATOR);

define('ROOT_PATH', dirname(__DIR__) . DS);

define('APP_PATH', ROOT_PATH . 'app' . DS);

define('CONFIG_PATH', APP_PATH . 'config' . DS);

define('CONTROLLER_PATH', APP_PATH . 'controller' . DS);

define('MODEL_PATH', APP_PATH . 'model' . DS);

define('VIEW_PATH', APP_PATH . 'view' . DS);

define('PUBLIC_PATH', ROOT_PATH . 'public' . DS);

define('LANGUAGE_PATH', PUBLIC_PATH . 'lang' . DS);

define('IMAGE_PATH', PUBLIC_PATH . 'images' . DS);

define('LIB_PATH', ROOT_PATH . 'water' . DS);

/*
 * ==============================================================
 * URL
 * ==============================================================
 */

define('PROTOCOL', 'http://');

define('DOMAIN', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));

define('SUB_FOLDER', str_replace('public', '', dirname((isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : ''))));

define('BASE_URL', PROTOCOL . DOMAIN . ((substr(SUB_FOLDER, -1, 1) == '/') ? substr(SUB_FOLDER, 0, strlen(SUB_FOLDER)-1) : SUB_FOLDER));

define('PUBLIC_URL', BASE_URL . '/public');

/*
 * ==============================================================
 * AUTOLOAD
 * ==============================================================
 */

require_once(LIB_PATH . 'autoload.php');

/*
 * ==============================================================
 * HELPERS
 * ==============================================================
 */

require_once(LIB_PATH . 'helpers.php');

/*
 * ==============================================================
 * ERROR HANDLER
 * ==============================================================
 */

$errorHandler = new core\error\ErrorHandler();

set_error_handler([&$errorHandler, 'waterErrorHandler']);
set_exception_handler([&$errorHandler, 'waterExceptionHandler']);
register_shutdown_function([&$errorHandler, 'waterShutdownHandler']);

/*
 * ==============================================================
 * CONFIG
 * ==============================================================
 */

require_once(CONFIG_PATH . 'config.php');

/*
 * ==============================================================
 * DEBUG
 * ==============================================================
 */

if (!defined('DEBUG_MODE') or (!is_integer(DEBUG_MODE) and !is_bool(DEBUG_MODE))) {
    define('DEBUG_MODE', 1);
}
// TODO: Create a default debug template to use when it is not defined by user.
if (!defined('DEBUG_VIEW') or !is_string(DEBUG_VIEW)) {
    define('DEBUG_VIEW', 'template/debug');
}
// TODO: Create a default error 404 template to use when it is not defined by user.
if (!defined('ERROR_404_VIEW') or !is_string(ERROR_404_VIEW)) {
    define('ERROR_404_VIEW', 'template/404');
}

/*
 * ==============================================================
 * SESSION
 * ==============================================================
 */

if (!defined('SESSION_LIFETIME') or (!is_integer(SESSION_LIFETIME) and !is_string(SESSION_LIFETIME))) {
    define('SESSION_LIFETIME', 7200);
}

$savePath = ROOT_PATH . 'storage' . DS . 'sessions';

ini_set('session.save_path', $savePath);
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.gc_probability', 1); // Ex: probability / divisor = 1 (100%)
ini_set('session.gc_divisor', 1);

/*
 * ==============================================================
 * CONTROLLER
 * ==============================================================
 */

if (!defined('CONTROLLER_INDEX') or !is_string(CONTROLLER_INDEX)) {
    define('CONTROLLER_INDEX', 'Home');
}

/*
 * ==============================================================
 * LANGUAGE
 * ==============================================================
 */

if (!defined('DEFAULT_LANGUAGE') or !is_string(DEFAULT_LANGUAGE)) {
    define('DEFAULT_LANGUAGE', 'pt-br');
}

/*
 * ==============================================================
 * ENCRYPTION
 * ==============================================================
 */

if (!defined('ENCRYPTION_KEY') or !is_string(ENCRYPTION_KEY)) {
    define('ENCRYPTION_KEY', '');
}

/*
 * ==============================================================
 * ROUTES
 * ==============================================================
 */

$router = new core\routing\Router();
require_once(CONFIG_PATH . 'routes.php');

/*
 * ==============================================================
 * START
 * ==============================================================
 */

new core\App();
