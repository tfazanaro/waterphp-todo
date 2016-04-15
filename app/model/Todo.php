<?php namespace model;

use core\base\Model;

class Todo extends Model
{
    public function __construct()
    {
        $this->setTable('todos');
        $this->setPrimaryKey('id');
    }
}