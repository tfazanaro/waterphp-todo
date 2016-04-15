<?php namespace core\utils;

final class Mail
{
    private $to;
    private $from;
    private $subject;
    private $message;
    private $headers;

    use \core\traits\ClassMethods;

    public function __construct()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        $this->to = '';
        $this->from = '';
        $this->subject = '';
        $this->message = '';
        $this->headers = array();

        if (defined('MAIL_CHARSET') and is_string(MAIL_CHARSET) and !empty(MAIL_CHARSET)) {
            $charset = MAIL_CHARSET;
        } else {
            $charset = 'iso-8859-1';
        }

        $this->headers[] = 'MIME-Version: 1.0';

        if (defined('MAIL_IS_HTML') and is_bool(MAIL_IS_HTML) and MAIL_IS_HTML) {
            $this->headers[] = 'Content-type: text/html; charset=' . $charset;
        } else {
            $this->headers[] = 'Content-type: text/plain; charset=' . $charset;
        }

        if (defined('MAIL_FROM') and is_string(MAIL_FROM) and !empty(MAIL_FROM)) {

            if (defined('MAIL_FROM_NAME') and is_string(MAIL_FROM_NAME) and !empty(MAIL_FROM_NAME)) {
                $this->headers[] = 'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM . '>';
            } else {
                $this->headers[] = 'From: ' . MAIL_FROM;
            }
            $this->headers[] = 'Return-path: ' . MAIL_FROM;
            $this->headers[] = 'Reply-to: ' . MAIL_FROM;
            $this->headers[] = 'X-Mailer: PHP/' . phpversion();

            $this->from = MAIL_FROM;
        }
    }

    private function isAllDefined() {

        if (empty($this->to)) {
            throw new \Exception('You need to pass a e-mail recipient on send method! See the documentation for more details.');
        }
        if (empty($this->subject)) {
            throw new \Exception('You need to set the subject to send a e-mail! See the documentation for more details.');
        }
        if (empty($this->message)) {
            throw new \Exception('You need to set the message to send a e-mail! See the documentation for more details.');
        }
        if (empty($this->from)) {
            throw new \Exception('You need to set MAIL_FROM on app/config.php to send a e-mail!');
        }
        return true;
    }

    private function to($to)
    {
        if (is_array($to) and count($to) > 0) {
            $this->to = implode(',', $to);
        } else if (is_string($to) and strlen($to) > 0) {
            $this->to = trim($to);
        }
    }

    public function subject($subject)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $subject, 1, ['string']);

        if (is_string($subject) and strlen($subject) > 0) {
            $this->subject = substr(trim($subject), 0, 70);
        }
    }

    public function message($message)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $message, 1, ['string']);

        if (is_string($message) and strlen($message) > 0) {
            $this->message = wordwrap(trim($message), 70);
        }
    }

    public function send($to)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $to, 1, ['string', 'array']);

        $this->to($to);

        if ($this->isAllDefined()) {
            return mail($this->to, $this->subject, $this->message, implode("\r\n", $this->headers), '-f' . $this->from);
        } else {
            return false;
        }
    }
}
