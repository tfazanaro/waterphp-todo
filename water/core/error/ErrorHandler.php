<?php namespace core\error;

use core\utils\Redirect;
use core\utils\Session;
use core\utils\Url;

final class ErrorHandler
{
    private $debug;
    private $title;
    private $stop;

    private function setTitle($code)
    {
        $this->debug = (defined('DEBUG_MODE')) ? DEBUG_MODE : 1;
        $this->title = '';
        $this->stop = false;

        switch ($code)
        {
            case E_ERROR:
            case E_USER_ERROR:
                $this->title = 'Fatal Error';
                $this->stop = true;
                break;

            case E_PARSE:
                $this->title = 'Parse Error';
                $this->stop = true;
                break;

            case E_WARNING:
            case E_USER_WARNING:
                $this->title = 'Warning';
                break;

            case E_NOTICE:
            case E_USER_NOTICE:
                $this->title = 'Notice';
                break;

            default:
                $this->title = 'Exception';
        }
    }

    // It will catch Warnings and Notices.
    // It will also catch E_USER_ERROR, E_USER_WARNING, E_USER...
    public function waterErrorHandler($code, $message, $file, $line)
    {
        $this->setTitle($code);

        $this->clearPrevious();

        Session::set('app_error_title', $this->title);
        Session::set('app_error_code', $code);
        Session::set('app_error_message', $message);
        Session::set('app_error_file', $file);
        Session::set('app_error_line', $line);
        Session::set('app_error_stop', $this->stop);

        $this->avoidTooManyRedirects($this->debug, $this->stop);
    }

    // It will always be called at the end of any script execution.
    // It will also catch Fatal Errors and Parse Errors.
    public function waterShutdownHandler()
    {
        $e = error_get_last();
        if (is_null($e) or (is_array($e) and count($e) == 0) or (isset($e['type']) and $e['type'] == '')) {
            return false;
        }
        $this->waterErrorHandler($e['type'], $e['message'], $e['file'], $e['line']);
        return true;
    }

    public function waterExceptionHandler($e)
    {
        $this->setTitle($e->getCode());

        $this->clearPrevious();

        Session::set('app_error_title', $this->title);
        Session::set('app_error_code', $e->getCode());
        Session::set('app_error_message', $e->getMessage());
        Session::set('app_error_file', $e->getFile());
        Session::set('app_error_line', $e->getLine());

        $this->avoidTooManyRedirects(true, true);
    }

    private function avoidTooManyRedirects($debug, $stop)
    {
        $code = Session::get('app_error_code');
        $message = Session::get('app_error_message');

        $file = Session::get('debug_backtrace_file');
        $line = Session::get('debug_backtrace_line');

        $file = ($file) ? $file : Session::get('app_error_file');
        $line = ($line) ? $line : Session::get('app_error_line');

        Session::set('app_error_file', $file, true);
        Session::set('app_error_line', $line, true);

        Session::forget('debug_backtrace_file');
        Session::forget('debug_backtrace_line');

        $noRedirect = 0;

        // These files can't be redirected to debug.
        $noRedirect += (strrpos($file, 'public' . DS . 'index.php')) ? 1 : 0;
        $noRedirect += (strrpos($file, 'config' . DS . 'config.php')) ? 1 : 0;
        $noRedirect += (strrpos($file, 'config' . DS . 'routes.php')) ? 1 : 0;
        $noRedirect += (strrpos($file, 'water'  . DS . 'helpers.php')) ? 1 : 0;
        $noRedirect += (strrpos($file, 'water'  . DS . 'core')) ? 1 : 0;

        // When is missing argument in a function (warning).
        $pos = strrpos(strtolower($message), 'missing argument');
        $missingArgument = (is_integer($pos)) ? true : false;

        if ($missingArgument) {
            // Stop function because warning message will be
            // defined in ClassMethods.
            return null;
        }

        if ($noRedirect and (!(isset($_SESSION['app_error_redirect']) and $_SESSION['app_error_redirect']))) {
            // On bootstrap, config or core files.
            if ($debug or $stop) {
                $d = new Debug();
                $d->index();
            }
        } else {
            Session::forget('app_error_redirect');

            if (($debug and !$stop)) {
                // If it's a Warning or Notice.
                throw new \ErrorException($message, $code, 0, $file, $line);
            } else if ($stop) {
                // If it's a Fatal Error or Parse Error.
                // If it's a Warning or Notice called by ErrorException.
                Redirect::to(Url::base('debug'));
            }
        }
    }

    private function clearPrevious()
    {
        Session::forget('app_error_title');
        Session::forget('app_error_code');
        Session::forget('app_error_message');
        Session::forget('app_error_file');
        Session::forget('app_error_line');
        Session::forget('app_error_stop');
    }
}
