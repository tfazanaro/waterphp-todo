<?php namespace core\error;

use core\base\Controller;
use core\base\View;
use core\utils\Session;

class Debug extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data = [
            'title' => Session::get('app_error_title'),
            'code' => Session::get('app_error_code'),
            'message' => Session::get('app_error_message'),
            'file' => Session::get('app_error_file'),
            'line' => Session::get('app_error_line')
        ];

        if (substr($this->data['message'], -1, 1) !== '.') {
            $this->data['message'] .= '.';
        }

        if (Session::get('app_error_stop')) {
            Session::stop();
        }
    }

    public function index()
    {
        $view = (defined('DEBUG_VIEW') ? DEBUG_VIEW : 'template/debug');
        View::load($view, $this->data);
        exit();
    }
}
