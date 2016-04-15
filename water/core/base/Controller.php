<?php namespace core\base;

abstract class Controller
{
    private $model;

    use \core\traits\ClassMethods;

    public function __construct($model = null)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 0, 1);
        self::validateArgType(__FUNCTION__, $model, 1, ['string', 'object', 'null']);

        $this->setModel($model);
    }

    private function setModel($model)
    {
        $this->model = null;

        if (is_string($model)) {
            $namespace = 'model\\' . str_replace(DS, '\\', $model);
            $this->model = new $namespace;
        }
        if (is_object($model)) {
            $this->model = $model;
        }
    }

    abstract function index();

    protected final function loadModel($model)
    {
        self::validateNumArgs(__FUNCTION__, func_num_args(), 1, 1);
        self::validateArgType(__FUNCTION__, $model, 1, ['string']);

        if (is_string($model)) {
            $namespace = 'model\\' . str_replace(DS, '\\', $model);
            $model = new $namespace;
            return $model;
        }
        return null;
    }

    protected final function model()
    {
        self::validateNumArgs(__FUNCTION__, func_num_args());
        return $this->model;
    }
}
