<?php namespace core\utils;

final class Request
{
    use \core\traits\ClassMethods;

    public static function all()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());

        $object = json_decode(file_get_contents("php://input"));

        if (is_object($object)) {
            $input = get_object_vars($object);
            return (is_array($input) and count($input) > 0) ? $input : null;
        }

        if (count($_POST) > 0) {

            $post_fields = array_keys($_POST);
            $post_values = array_values($_POST);

            $input = [];

            foreach($post_fields as $i => $name) {
                $input[$name] = $post_values[$i];
            }
            return (count($input) > 0) ? $input : null;
        }
        return null;
    }

    public static function get($name)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $name, 1, ['string']);

        $input = self::all();

        if ($input and is_string($name)) {
            if (array_key_exists($name, $input)) {
                return $input[$name];
            }
        }
        return null;
    }
}