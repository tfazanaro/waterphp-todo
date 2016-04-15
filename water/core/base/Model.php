<?php namespace core\base;

use core\database\Crud;

class Model extends Crud
{
    public function __construct($table, $column = 'id')
    {
        parent::setTable($table);
        parent::setPrimaryKey($column);
    }
}
