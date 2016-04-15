<?php namespace core\traits;

trait ClassMethods
{
    private static function getClassName()
    {
        $namespace = (strrpos(__CLASS__, 'ClassMethods')) ? '' : __CLASS__;

        $parts = explode('\\', $namespace);

        $class = $parts[(count($parts) - 1)];

        if ($class === 'Crud') {
            // Model extends Crud, so user calls functions by Model.
            $class = 'Model';
        }
        return ($class) ? $class . '::' : '';
    }

    public static function validateNumArgs($function, $numArgs, $min = 0, $max = 0)
    {
        if ($numArgs >= $min and $numArgs <= $max) {
            return true;
        }
        if ($numArgs > $max) {
            $msg = self::getClassName() . $function . "() expects at most " . $max . (($max > 1) ? " parameters, " : " parameter, ") . $numArgs . " given.";
        }
        if ($numArgs < $min) {
            $msg = self::getClassName() . $function . "() expects at least " . $min . (($min > 1) ? " parameters, " : " parameter, ") . $numArgs . " given.";
        }
        if ($max == 0 and $numArgs > 0) {
            $msg = self::getClassName() . $function . "() doesn't expect any parameter.";
        }

        $_SESSION['debug_backtrace_file'] = debug_backtrace()[1]['file'];
        $_SESSION['debug_backtrace_line'] = debug_backtrace()[1]['line'];

        if ($numArgs == 0) {
            $_SESSION['app_error_redirect'] = 1;
        }
        trigger_error($msg, E_USER_WARNING);
    }

    public static function validateArgType($function, $arg, $number, $types)
    {
        $valid = false;

        foreach ($types as $type) {
            switch ($type) {
                case 'null':
                    if (is_null($arg)) {
                        $valid = true;
                    }
                    break;
                case 'array':
                    if (is_array($arg)) {
                        $valid = true;
                    }
                    break;
                case 'object':
                    if (is_object($arg)) {
                        $valid = true;
                    }
                    break;
                case 'bool':
                    if (is_bool($arg)) {
                        $valid = true;
                    }
                    break;
                case 'string':
                    if (is_string($arg)) {
                        $valid = true;
                    }
                    break;
                case 'integer':
                    if (is_integer($arg)) {
                        $valid = true;
                    }
                    break;
                case 'float':
                    if (is_float($arg)) {
                        $valid = true;
                    }
                    break;
                case 'double':
                    if (is_double($arg)) {
                        $valid = true;
                    }
                    break;
            }
        }
        if (!$valid) {

            $expects = implode(' or ', $types);

            $_SESSION['debug_backtrace_file'] = debug_backtrace()[1]['file'];
            $_SESSION['debug_backtrace_line'] = debug_backtrace()[1]['line'];

            $msg = self::getClassName() . $function . "() expects parameter " . $number . " to be " . $expects . ", " . gettype($arg) . " given.";

            trigger_error($msg, E_USER_WARNING);
        }
    }
}
